<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentAttempt;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserCard;
use App\Repositories\MovieShowRepository;
use App\Traits\APITrait;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class  OrderController extends Controller
{
    use APITrait;

    private OrderRepositoryInterface $orderRepository;
    private PosUserRepositoryInterface $posUserRepository;

    private MovieShowRepositoryInterface $movieShowRepository;
    private TheaterRepositoryInterface $theaterRepository;
    private CartRepositoryInterface $cartRepository;
    private CardRepositoryInterface $cardRepository;
    private ZoneRepositoryInterface $zoneRepository;
    private ItemRepositoryInterface $itemRepository;
    private UserRepositoryInterface $userRepository;


    public function __construct(OrderRepositoryInterface $orderRepository, MovieShowRepository $movieShowRepository, TheaterRepositoryInterface $theaterRepository, CartRepositoryInterface $cartRepository, PosUserRepositoryInterface $posUserRepository, CardRepositoryInterface $cardRepository, ZoneRepositoryInterface $zoneRepository, ItemRepositoryInterface $itemRepository, UserRepositoryInterface $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->theaterRepository = $theaterRepository;
        $this->cartRepository = $cartRepository;
        $this->posUserRepository = $posUserRepository;
        $this->cardRepository = $cardRepository;
        $this->zoneRepository = $zoneRepository;
        $this->itemRepository = $itemRepository;
        $this->userRepository = $userRepository;
    }

    public function attempt()
    {

        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'payment_method_id' => 'required',
            'cart_id' => 'required'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }


        $payment_method =  PaymentMethod::find($form_data['payment_method_id']);


        try {
            $cart = $this->cartRepository->getCartById($form_data['cart_id']);
            $cart_details = $this->cartRepository->getCartDetails($cart);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Cart Error', $e->getMessage()));
        }


        $subtotal = $cart_details['subtotal']['value'];

        $user_id = request()->user->id;
        $user_type = request()->user_type;
        $field = get_user_field_from_type($user_type);

        $payment_attempt = new PaymentAttempt();
        $payment_attempt->{$field} = $user_id;
        $payment_attempt->amount = $subtotal;
        $payment_attempt->payment_method_id = $form_data['payment_method_id'];
        $payment_attempt->action = "COMPLETE_ORDER";
        $payment_attempt->reference = $form_data['cart_id'];
        $payment_attempt->save();
        $token = md5($payment_attempt->id . '' . $user_id . '' . $payment_attempt->payment_method_id . '' . round($payment_attempt->amount, 0));


        switch ($payment_method->key) {
            case 'CASH':

                try {
                    $order = $this->orderRepository->createOrderFromCart($payment_attempt);
                } catch (\Throwable $th) {
                    return $this->response(notification()->error('Order not completed', 'Your order has not been completed'));
                }
                // dd($order);
                $payment_attempt->completed_at = now();
                $payment_attempt->converted_at = now();
                $payment_attempt->save();

                return $this->responseData([
                    'order_id' => $order["order_id"],
                ], notification()->success('Order completed', 'Your order has been successfully completed'));

                break;

            case 'OP':

                return $this->responseData([
                    'redirect' => route(
                        "payment.initialize",
                        [
                            'token'=>$token,
                            'payment_attempt_id' => $payment_attempt->id,

                        ]

                    )
                ]);

                break;

            case 'WP':


                // Check if user is identified by wallet card number from cart

                // Check if the balance is enough

                $card_number = $cart->card_number ?? null;


                if ($card_number) {
                    $user_card = UserCard::where('barcode', $card_number)->first();
                    if (!$user_card) {
                        return $this->response(notification()->error('Card Error', 'The card number is not linked to any valid barcode.'));
                    }
                } elseif ($cart) {
                    $user_card = UserCard::where('user_id', $cart->user_id)->first();
                    if (!$user_card) {
                        return $this->response(notification()->error('Card Error', 'No valid card found for this user.'));
                    }
                } else {
                    return $this->response(notification()->error('No user card found', 'No user card found'));
                }
                // dd("here");
                $wallet_user =  User::find($user_card->user_id);

                $wallet_card =  $this->cardRepository->getActiveCard($wallet_user);
                //               dd($subtotal);
                // dd($wallet_card['wallet_balance']['value'] < $subtotal);
                if ($wallet_card['wallet_balance']['value'] < $subtotal) {
                    return $this->response(notification()->error('No enough balance', 'No enough balance'));
                }


                try {
                    $order = $this->orderRepository->createOrderFromCart($payment_attempt);
                } catch (\Throwable $th) {
                    return $this->response(notification()->error('Order not completed', 'Your order has not been completed'));
                }

                $payment_attempt->completed_at = now();
                $payment_attempt->converted_at = now();
                $payment_attempt->save();

                // Create wallet transaction of type OUT. of amount 

                $this->cardRepository->createWalletTransaction("out", $subtotal, $wallet_user, "Wallet deducted for order", $order["order_id"]);


                return $this->response(notification()->success('Order completed', 'Your order has been successfully completed'));

            default:
                # code...
                break;
        }
    }


    public function get()
    {

        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'barcode' => 'required',
        ]);

        if ($validator->errors()->count() > 0) {
            return $this->responseValidation($validator);
        }

        try {
            $order = $this->orderRepository->getOrderByBarcode($form_data['barcode']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order not found', $e->getMessage()));
        }

        $order_seats = OrderSeat::whereNull('deleted_at')
            ->where('order_id', $order->id)
            ->whereNull('refunded_at')
            ->get()
            ->map(function ($order_seat) {

                $movieShow = $order_seat->movieShow;


                return [
                    'label' => $order_seat->label,
                    'seat' => $order_seat->seat,
                    'price' => currency_format($order_seat->price),
                    'discount' => currency_format($order_seat->discount),
                    'final_price' => currency_format($order_seat->final_price),
                    'gained_points' => $order_seat->gained_points,
                    'show_details' => [
                        'movie_name' => $movieShow->movie->name ?? '',
                        'theater' => $movieShow->theater->hall_number ?? '',
                        'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
                        'showtime' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : ''
                    ]
                ];
            });



        $order_items = OrderItem::whereNull('deleted_at')
            ->where('order_id', $order->id)
            ->get();

        $order_topups = OrderTopup::whereNull('deleted_at')
            ->where('order_id', $order->id)
            ->get();


        return $this->responseData([
            'order' => [
                'id' => $order->id,
                'reference' => $order->reference,
                'barcode' => $order->barcode,
                'system' => $order->system->label ?? '',
                'payment_method' => $order->paymentMethod->label ?? '',
                'user' => $order->user?->only(['id', 'full_name', 'phone', 'email']),
                'cashier' => $order->posUser?->only(['id', 'name']),
                'order_date' => now()->parse($order->created_at)->format('d M, Y H:i:s'),
                'printed' => $order->printed
            ],
            'seat' => $order_seats,
            'items' => $order_items,
            'topups' => $order_topups
        ]);
    }


    public function refund()
    {
        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'order_id' => 'required',
            'order_seat_ids' => 'required|array',
            'manager_pin' => 'required',
            'manager_id' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }


        $user_id = request()->user->id;
        $user_type = request()->user_type;
        $field = get_user_field_from_type($user_type);
        $user_branch = request()->user->branch_id;

        $order_id = $form_data['order_id'];

        try {
            $order = Order::findOrFail($order_id);
        } catch (\Throwable $th) {
            //throw $th;
        }

        $payment_method = $order->paymentMethod;

        if (!$payment_method) {
            return $this->response(notification()->success('Refund Failed', 'Refund Failed'));
        }

        try {
            $manager = $this->posUserRepository->getManagerByIdAndPin($form_data['manager_id'], $form_data['manager_pin'], $user_branch);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Wrong Pin', $th->getMessage()));
        }

        try {
            $order_seats = $this->orderRepository->getOrderSeatsByIds($form_data['order_id'], $form_data['order_seat_ids']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('No matching order seats found for the given order', $th->getMessage()));
        }

        if ($order_seats->where('discount', '>', 0)) {
            return $this->response(notification()->error("Unable to refund", "Can't refund discounted seats:" . $order_seats->where('discount', '>', 0)->pluck('id')->implode(",")));
        }

        $total_amount = 0;
        $total_points = 0;

        foreach ($order_seats as $order_seat) {
            $order_seat->refunded_at = now();
            $order_seat->refunded_cashier_id = $user_id;
            $order_seat->refunded_manager_id = $manager["id"];
            $total_points += $order_seat->gained_points;
            $total_amount += $order_seat->price;
            $order_seat->save();
        }


        if ($payment_method->key == 'CASH') {
            return $this->response(notification()->success('cash', 'Cash.'));
        }

        $this->cardRepository->createWalletTransaction("in", $total_amount, $order->user, "Recharge wallet");
        return $this->response(notification()->success('Refund Successful', 'Refund Successful'));
    }

    public function purchaseHistory()
    {

        $user = request()->user;


        $orders = $this->orderRepository->getUserOrders($user->id)->map(function ($order) {

            $order_seats = $this->orderRepository->getOrderSeats($order->id, $groude = true);

            $zone_ids = $order_seats->pluck('zone_id');
            $zones = $this->zoneRepository->getZonesPrices($zone_ids)->keyBy('id');
            $total_discounts = 0;
            $subtotal = 0;


            $seat_lines = $order_seats->map(function ($order_seat) use ($zones, &$total_discounts) {

                $zone = $zones[$order_seat['zone_id']];
                if (!$zone) {
                    return null;
                }

                $unit_price = $order_seat['price'];

                $total_discounts += $order_seat['total_discount'];


                return [
                    'id' => $order_seat['order_id'],
                    'type' => "Seat",
                    'label' => $zone->label,
                    'unit_price' => currency_format($order_seat['price']),
                    'quantity' => $order_seat['quantity'],
                    'price' => currency_format(($unit_price * $order_seat['quantity'])),
                    'discount' => currency_format($order_seat['total_discount']),
                ];
            })->filter();

            $order_items = $this->orderRepository->getOrderItems($order->id, true);
            // return $order_items;
            $item_ids = $order_items->pluck('item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $item_lines = $order_items->map(function ($order_item) use ($items) {
                $item = $items[$order_item['item_id']];
                $unit_price = $item->price;

                return [
                    'id' => $order_item['order_id'],
                    'type' => "Item",
                    'label' => $item->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_item['quantity'],
                    'price' => currency_format($unit_price * $order_item['quantity']),
                ];
            })->filter();



            $order_topups = $this->orderRepository->getOrderTopups($order->id, true);
            $topup_lines = $order_topups->map(function ($order_topup) {
                $unit_price = $order_topup->price;

                return [
                    'id' => $order_topup['order_id'],
                    'type' => "Topup",
                    'label' => "Top-up amount",
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_topup['quantity'],
                    'price' => currency_format($unit_price * $order_topup['quantity']),
                ];
            });
            // return $order_topups;
            $lines = $seat_lines->merge($item_lines)->merge($topup_lines);

            // $lines = $lines->merge($order->items->map(function ($item) {
            //     return [
            //         'label' => $item->label,
            //         'qualtity' => 1,
            //         'price' => currency_format($item->price),
            //     ];
            // }));

            // $lines = $lines->merge($order->topups->map(function ($topup) {
            //     return [
            //         'label' => $topup->label,
            //         'qualtity' => 1,
            //         'price' => currency_format($topup->amount),
            //     ];
            // }));



            $subtotal = $lines->sum('price.value');
            $total_discounts = $lines->sum('discount.value');


            return [
                'order_id' => $order->id,
                'date' => $order->created_at,
                'quantity' => $order->seats->count(),
                'subtotal' => currency_format($subtotal),
                'total_discount' => currency_format($total_discounts),
                'total' => currency_format($subtotal - $total_discounts),
                'lines' => $lines

            ];
        });
        return $this->responseData($orders);
    }


    public function details($order_id)
    {
        try {
            $order = Order::where('id', $order_id)->whereNull('deleted_at')->firstOrFail();
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order not found', $e->getMessage()));
        }

        $user_id = $order->user_id;


        $user = $this->userRepository->getUserById($user_id);


        $user_loyalty_balance = $this->cardRepository->getLoyaltyBalance($user);



        $order_seats = $this->orderRepository->getOrderSeats($order->id, $groude = true);

        $zone_ids = $order_seats->pluck('zone_id');

        $zones = $this->zoneRepository->getZonesPrices($zone_ids)->keyBy('id');

        // $price_group= $zones->map(function ($zone) {
        //     return $zone->priceGroup->label;
        // });
        // return $price_group_ids;

        $order_seats = $order_seats->map(function ($seats) use ($order, $zones) {
            $movieShow = $seats->movieShow;
            $movie = $movieShow->movie;
            // $zone_label = $zones->get($seats->zone_id)['label'] ?? 'Unknown Zone';
            return [
                'order_id' => $order->id,
                'movie_name' => $movie->name ?? '',
                'movie_image' => get_image($movie->main_image) ?? '',

                'duration' => minutes_to_human($movie->duration),
                'order_barcode' => $order->barcode,
                'booking_id' => $movieShow->created_at ? now()->parse($movieShow->created_at)->format('Y-m') . '-' . $order->id : '',
                'order_barcode' => $order->barcode,
                'branch' => $movieShow->theater->branch->label ?? '',
                'date' => $movieShow->date ? now()->parse($movieShow->date)->format('Y-m-d') : '', // Format as YYYY-MM-DD
                'time' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : '',
                'theater' => $movieShow->theater->label ?? '',
                'seats' => $seats->seats,
            ];
        });

        return $this->responseData([
            'loyalty_points_balance' => [
                "value" => $user_loyalty_balance,
                "display" => $user_loyalty_balance . ' points'
            ],
            'order' => $order_seats,
        ]);
        // return [
           
        // ];
    }
}
