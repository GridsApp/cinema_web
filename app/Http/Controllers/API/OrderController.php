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
use App\Models\MovieShow;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentAttempt;
use App\Models\PaymentMethod;
use App\Models\ReservedSeat;
use App\Models\Time;
use App\Models\User;
use App\Models\UserCard;
use App\Repositories\MovieShowRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use twa\cmsv2\Traits\APITrait;

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

    public function createOrder($cart_id, $payment_method, $payment_reference = null)
    {

        try {
            $cart = $this->cartRepository->getCartById($cart_id);
            $cart_details = $this->cartRepository->getCartDetails($cart);

            $has_topup = collect($cart_details['lines'])->contains(function ($item) {
                return $item['type'] === 'Topup';
            });


            if ($has_topup && ($payment_method->key === 'WP' || $payment_method->key === 'WP-POS')) {
                return $this->response(notification()->error('Cannot proceed with wallet payment', 'There is a top-up amount in the cart, and wallet payment is not allowed.'));
            }

            // dd($has_topup);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Cart Error', $e->getMessage()));
        }

        $user_id = request()->user->id;
        $user_type = request()->user_type;
        $field = get_user_field_from_type($user_type);
        $branch_id = request()->branch_id;


        $subtotal = $cart_details['subtotal']['value'];


        $payment_attempt = new PaymentAttempt();
        $payment_attempt->{$field} = $user_id;
        $payment_attempt->amount = $subtotal;
        $payment_attempt->payment_method_id = $payment_method->id;
        $payment_attempt->action = "COMPLETE_ORDER";
        $payment_attempt->reference = $cart_id;
        $payment_attempt->payment_reference = $payment_reference;
        $payment_attempt->save();
        $token = md5($payment_attempt->id . '' . $user_id . '' . $payment_attempt->payment_method_id . '' . round($payment_attempt->amount, 0));

       


       
        switch ($payment_method->payment_type) {
            case 'cash':
            case 'cc_dc':
           
                try {
                    $order = $this->orderRepository->createOrderFromCart($payment_attempt, $branch_id);
                } catch (\Throwable $th) {
                    return $this->response(notification()->error('Order not completed', $th->getMessage()));
                }


                $payment_attempt->completed_at = now();
                $payment_attempt->converted_at = now();
                $payment_attempt->save();

                return $this->responseData([
                    'order_id' => $order["order_id"],
                    ...$this->details($order["order_id"], false),
                ], notification()->success('Order completed', 'Your order has been successfully completed'));

                break;

            case 'op':
        
              
              
                return $this->responseData([
                    'redirect' => route(
                        "payment.initialize",
                        [
                            'token' => $token,
                            'payment_attempt_id' => $payment_attempt->id,

                        ]

                    )
                ]);

                break;


            case 'wp':

                $card_number = $cart->card_number ?? null;


                if ($card_number) {
                    try {
                        $user_card = $this->cardRepository->getCardByBarcode($card_number);
                    } catch (\Exception $e) {
                        return $this->response(notification()->error('The card number is not linked to any valid barcode', $e->getMessage()));
                    }
                } elseif ($cart) {
                    try {
                        $user_card = $this->cardRepository->getCardByUserId($cart->user_id);
                    } catch (\Exception $e) {
                        return $this->response(notification()->error('No valid card found for this user', $e->getMessage()));
                    }
                } else {
                    return $this->response(notification()->error('No user card found', 'No user card found'));
                }

                $wallet_user =  User::find($user_card->user_id);

                $wallet_card =  $this->cardRepository->getActiveCard($wallet_user);

                if ($wallet_card['wallet_balance']['value'] < $subtotal) {
                    return $this->response(notification()->error('No enough balance', 'No enough balance'));
                }


                try {
                    $order = $this->orderRepository->createOrderFromCart($payment_attempt, $branch_id);
                } catch (\Throwable $th) {
                    return $this->response(notification()->error('Order not completed', 'Your order has not been completed'));
                }

                $payment_attempt->completed_at = now();
                $payment_attempt->converted_at = now();
                $payment_attempt->save();

                if ($subtotal > 0 && $user_id) {
                    if ($cart->pos_user_id) {
                        $operator_type = "App\Models\PosUser";
                        $operator_id = $cart->pos_user_id;
                    } elseif ($cart->user_id) {
                        $operator_type = "App\Models\User";
                        $operator_id = $cart->user_id;
                    } else {
                        $operator_type = null;
                        $operator_id = null;
                    }

                    $this->cardRepository->createWalletTransaction("out", $subtotal, $wallet_user, "Wallet deducted for order", $order["order_id"], null, $operator_id, $operator_type);
                }

                return $this->responseData([
                    'order_id' => $order["order_id"],
                    ...$this->details($order["order_id"], false),
                ], notification()->success('Order completed', 'Your order has been successfully completed'));


                break;
            // return $this->response(notification()->success('Order completed', 'Your order has been successfully completed'));

            default:

                break;
        }
    }


    public function attempt()
    {

        $form_data = clean_request(['cart_id']);




        $check = $this->validateRequiredFields($form_data, ['payment_method_id', 'cart_id']);

        if ($check) {
            return $this->response($check);
        }


        $payment_reference = $form_data['payment_reference'] ?? null;

        try {
            $payment_method = $this->orderRepository->getPaymentMethodById($form_data['payment_method_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Payment Method Not Found', $th->getMessage()));
        }


        // dd(request()->user);
        // return $this->createOrder(request()->user , $form_data['cart_id'] , $payment_method);
        return $this->createOrder($form_data['cart_id'], $payment_method, $payment_reference);
    }
    public function refund()
    {

        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'order_id' => 'required',
            'order_seat_codes' => 'required|array',
            'manager_pin' => 'required',
            'manager_id' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }


        $user_id = request()->user->id;

        $user_type = request()->user_type;;
        $field = get_user_field_from_type($user_type);
        $user_branch = request()->user->branch_id;



        $order_id = $form_data['order_id'];


        try {

            $order = $this->orderRepository->getOrderById($order_id);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Order Not Found', 'Order not found.'));
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
            $order_seats = $this->orderRepository->getOrderSeatsByCodes($form_data['order_id'], $form_data['order_seat_codes']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('No matching order seats found for the given order', $th->getMessage()));
        }


        $order_seats_with_imtiyaz_phone = $order_seats->whereNotNull('imtiyaz_phone');
        if ($order_seats_with_imtiyaz_phone->count() > 0) {
            return $this->response(notification()->error("Unable to refund", "Can't refund seats with imtiyaz_phone associated."));
        }

        // dd($order_seats);
        $order_coupons = OrderCoupon::where('order_id', $order_id)
            ->get();


        if ($order_coupons->count() > 0) {
            return $this->response(notification()->error("Unable to refund", "Can't refund discounted seats:" . $order_seats->where('discount', '>', 0)->pluck('id')->implode(",")));
        }

        $total_amount = 0;
        $total_points = 0;


        try {
            DB::beginTransaction();
            foreach ($order_seats as $order_seat) {
                $order_seat->refunded_at = now();
                $order_seat->refunded_cashier_id = $user_id;
                $order_seat->refunded_manager_id = $manager["id"];
                $total_points += $order_seat->gained_points;
                $total_amount += $order_seat->price;
                $order_seat->save();


                try {

                    $this->theaterRepository->removeFromReservedSeats($order_seat['movie_show_id'], $order_seat['seat']);
                } catch (\Throwable $th) {
        
                }

                if ($payment_method->key != 'CASH') {


                    if ($total_amount > 0 && $user_id) {

                        if ($order->pos_user_id) {

                            $operator_type = "App\Models\PosUser";
                            $operator_id = $order->pos_user_id;
                        } else {
                            $operator_type = null;
                            $operator_id = null;
                        }

                        $walletTransaction = $this->cardRepository->createWalletTransaction("in", $total_amount, $order->user, "Recharge wallet", $order->id, null, $operator_id, $operator_type);
             
                        $loyaltyTransaction =    $this->cardRepository->createLoyaltyTransaction("out", $total_points, $order->user, "Remove points of ticket", $order->id);

                     
                    }
                }
            }

            DB::commit();
            return $this->responseData(
                $this->details($order_id, false),
                notification()->success('Refund Successful', 'Your order has been successfully refunded')
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(notification()->error('Refund Failed', 'An error occurred: ' . $th->getMessage()));
        }





        // return $this->responseData(
        //     $this->details($order_id, false),
        //     notification()->success('Refund Successful', 'Your order has been successfully refunded')
        // );
    }
    //To be checked By hovig
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


        return $this->details($order);

        // $total_discount = 20000;


        try {
            $order_seats = $this->orderRepository->getOrderSeats($order->id,  false);
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order seats not found', $e->getMessage()));
        }

        $order_seats = $order_seats->map(function ($order_seat) {
            return [
                'label' => $order_seat->label,
                'seat' => $order_seat->seat,
                'price' => currency_format($order_seat->price),
                'discount' => currency_format($order_seat->discount),
                'final_price' => currency_format($order_seat->price),
                'gained_points' => $order_seat->gained_points,
                'show_details' => [
                    'movie_name' => $order_seat->movie->name ?? '',
                    'theater' => $order_seat->theater->hall_number ?? '',
                    'showdate' => now()->parse($order_seat->date)->format('d M, Y') ?? '',
                    'showtime' => isset($order_seat->time->label) ? convertTo12HourFormat($order_seat->time->label) : ''
                ]
            ];
        });

        try {
            $order_items = $this->orderRepository->getOrderItems($order->id, false);
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order Items not found', $e->getMessage()));
        }

        $order_items = $order_items->map(function ($order_item) {
            return [
                'item_id' => $order_item->item_id,
                // 'item_id' => $order_item->item_id,
                'label' => $order_item->label,
                'price' => currency_format($order_item->price),

            ];
        });


        try {
            $order_topups =  $this->orderRepository->getOrderTopups($order->id, false);
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order Topups not found', $e->getMessage()));
        }

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
            'seats' => $order_seats,
            'items' => $order_items,
            'topups' => $order_topups
        ]);
    }

    // To be testedd
    public function purchaseHistory()
    {

        $user = request()->user;
        $orders = $this->orderRepository->getUserOrders($user->id)->map(function ($order) {

            try {
                $order_seats = $this->orderRepository->getOrderSeats($order->id, $groude = true);
            } catch (\Throwable $e) {
                return $this->response(notification()->error('Order seats not found', $e->getMessage()));
            }

            $zone_ids = $order_seats->pluck('zone_id');
            $zones = $this->zoneRepository->getZones($zone_ids)->keyBy('id');
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

            try {
                $order_items = $this->orderRepository->getOrderItems($order->id, true);
            } catch (\Throwable $e) {
                return $this->response(notification()->error('Order Items not found', $e->getMessage()));
            }


            $item_ids = $order_items->pluck('item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $item_lines = $order_items->map(function ($order_item) use ($items) {
               
                $unit_price = $order_item->price;

                return [
                    'id' => $order_item['order_id'],
                    'type' => "Item",
                    'label' => $order_item->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_item['quantity'],
                    'price' => currency_format($unit_price * $order_item['quantity']),
                ];
            })->filter();

            try {
                $order_topups = $this->orderRepository->getOrderTopups($order->id, true);
            } catch (\Throwable $e) {
                return $this->response(notification()->error('Order Topups not found', $e->getMessage()));
            }

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

            $seat_lines = collect($seat_lines);
            // $item_lines = collect($item_lines);
            // $topup_lines = collect($topup_lines);

            $lines = $seat_lines->merge($item_lines)->merge($topup_lines);


            $subtotal = $lines->sum('price.value');
            $total_discounts = $lines->sum('discount.value');


            return [
                'order_id' => $order->id,
                'date' => $order->created_at,
                'quantity' => $order->seats->count(),
                'subtotal' => currency_format($subtotal),
                'total_discount' => currency_format($total_discounts),
                'total' => currency_format($subtotal - $total_discounts),
                'payment_method' => $order->paymentMethod->label,
                'lines' => $lines

            ];
        });
        return $this->responseData($orders);
    }


    public function details($order_id, $API = true)
    {


        if (!is_numeric($order_id)) {
            $order = $order_id;
        } else {
            try {
                $order = $this->orderRepository->getOrderById($order_id);
            } catch (\Throwable $e) {
                return $this->response(notification()->error('Order not found', $e->getMessage()));
            }
        }

        $user_id = $order->user_id;

        try {
            $user = $this->userRepository->getUserById($user_id);
        } catch (\Throwable $th) {
            $user = null;
        }

        $user_loyalty_balance = null;
        if ($user) {
            $user_loyalty_balance = $this->cardRepository->getLoyaltyBalance($user);
        }

        $user_wallet_balance = null;
        if ($user) {
            $user_wallet_balance = $this->cardRepository->getWalletBalance($user);
        }

        if ($user) {
            $user_card_number = $this->cardRepository->getCardByUserId($user->id);
        }
        $order_seats = null;
        try {

            $order_seats = $this->orderRepository->getOrderSeats($order->id, $grouped = false);
        } catch (\Throwable $e) {

            return $this->response(notification()->error('Order seats not found', $e->getMessage()));
        }


        $refunded_seats = [];
        try {

            $refunded_seats = $this->orderRepository->getOrderRefundedSeats($order->id, $grouped = false);
        } catch (\Throwable $e) {

            return $this->response(notification()->error('Order seats not found', $e->getMessage()));
        }

        $order_items = null;
        try {

            $order_items = $this->orderRepository->getOrderItems($order->id, $grouped = false);
        } catch (\Throwable $e) {

            return $this->response(notification()->error('Order seats not found', $e->getMessage()));
        }

        $order_topups = null;
        try {

            $order_topups = $this->orderRepository->getOrderTopups($order->id, $grouped = false);
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order seats not found', $e->getMessage()));
        }

        try {

            $order_discounts = $this->orderRepository->getOrderCoupons($order->id);
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Order Discounts not found', $e->getMessage()));
        }

        $refunded_seats =  $refunded_seats->map(function ($seats) use ($order) {
            $movie = $seats->movie;


            $type =  $seats->theater->PriceGroup->label ?? '';

            $zone = $seats->zone;

            if ($zone) {
                $type .= $zone->default == 1 ? '' : " " . $zone->condensed_label;
            }


            return [
                'movie_name' => $movie->name ?? '',
                'movie_image' => get_image($movie->main_image) ?? '',
                'duration' => minutes_to_human($movie->duration),
                'booking_id' => $seats->created_at ? now()->parse($seats->created_at)->format('Y-m') . '-' . $order->id : '',
                'branch' => $seats->theater->branch->label ?? '',
                'date' => now()->parse($seats->date)->format('d M, Y'),
                'time' => isset($seats->time->label) ? convertTo12HourFormat($seats->time->label) : '',
                'theater' => $seats->theater->label ?? '',
                'theater_number' => (int) ($seats->theater->hall_number ?? 0),
                'seats' => $seats->seat,
                'price' => currency_format($seats->price),
                'gained_points' => $seats->gained_points,
                'type' => $type,
                'is_imtiyaz' => !empty($seats->imtiyaz_phone),
            ];
        });



        $order_seats = $order_seats->map(function ($seats) use ($order) {



            $type =  $seats->theater->PriceGroup->label ?? '';

            $zone = $seats->zone;

            if ($zone) {
                $type .= $zone->default == 1 ? '' : " " . $zone->condensed_label;
            }



            $movie = $seats->movie;
            return [
                'movie_name' => $movie->name ?? '',
                'movie_image' => get_image($movie->main_image) ?? '',
                'duration' => minutes_to_human($movie->duration),
                'booking_id' => $seats->created_at ? now()->parse($seats->created_at)->format('Y-m') . '-' . $order->id : '',
                'branch' => $seats->theater->branch->label ?? '',
                'date' => now()->parse($seats->date)->format('d M, Y'),
                'time' => isset($seats->time->label) ? convertTo12HourFormat($seats->time->label) : '',
                'theater' => $seats->theater->label ?? '',
                'theater_number' => (int) ($seats->theater->hall_number ?? 0),
                'seats' => $seats->seat,
                'price' => currency_format($seats->price),
                'gained_points' => $seats->gained_points,
                'type' => $type,
                'is_imtiyaz' => !empty($seats->imtiyaz_phone),


            ];
        });

        $order_items = $order_items->map(function ($items) {
            return [
                'label' => $items->label,
                'price' => currency_format($items->price),

            ];
        });
        $order_topups = $order_topups->map(function ($topups) {
            return [
                'label' => $topups->label,
                'price' => currency_format($topups->price),
            ];
        });

        $pos_user_id = $order->pos_user_id;
        try {
            $pos_user_id = $this->posUserRepository->getUserById($pos_user_id);
        } catch (\Throwable $th) {
            $pos_user = null;
        }

        // dd( $pos_user_id->branch);




        $order_discounts = $order_discounts->map(function ($item) {
            return [
                'label' => $item->label ?? '',
                'price' => currency_format($item->amount),

            ];
        });


        $subtotal = collect($order_seats)->where('is_imtiyaz', false)->sum('price.value') +
            collect($order_items)->sum('price.value') +
            collect($order_topups)->sum('price.value');


        $discount =  collect($order_discounts)->sum('price.value');

        $total = $subtotal - $discount;
        if ($total < 0) {
            $total = 0;
        }

        $result = [
            'loyalty_points_balance' => $user_loyalty_balance ? [
                "value" => $user_loyalty_balance,
                "display" => $user_loyalty_balance . ' points'
            ] : null,

            'wallet_balance' => currency_format($user_wallet_balance),
            'order' => [
                'id' => $order->id,
                'order_date' => now()->parse($order->created_at)->format('d M, Y H:i:s'),

                'long_id' => $this->orderRepository->generateLongId($order->id),
                'reference' =>  $order->reference,
                'barcode' =>  $order->barcode,
                'system' => $order->system->label ?? '',
                'payment_method' => $order->paymentMethod->label ?? '',
                'customer' => $order->user?->only(['id', 'full_name', 'phone', 'email']),
                'cashier' => $pos_user_id->name ?? null,
                'branch' => [
                    'label_en' => $pos_user_id->branch->label_en ?? null,
                    'label_ar' => $pos_user_id->branch->label_ar ?? null
                ],
                'card_number' => $user_card_number->barcode ?? null,
                'printed_at' => $order->printed_at,

                'subtotal' => currency_format($subtotal),
                'discount' =>  currency_format($discount),
                'total' =>  currency_format($total),
                'can_refund' => true
            ],
            'tickets' => $order_seats,
            'refunded_tickets' => $refunded_seats,
            'items' =>  $order_items,
            'topups' => $order_topups,
            'discounts' => $order_discounts,



        ];

        if ($API) {
            return $this->responseData($result, notification()->success('Order fetched', 'Order fetched'));
        } else {
            return $result;
        }
    }
    public function print()
    {
        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'order_id' => 'required',
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }
        $order_id = $form_data['order_id'];

        try {
            $order = $this->orderRepository->getOrderById($order_id);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order Not Fount', $e->getMessage()));
        }

        $order->printed_at = now();
        $order->save();

        return $this->response(notification()->success('Order Printed Successfully', 'Order Printed Successfully'));
    }


    public function getReservedTotal()
    {


        $today = Carbon::today();
        $currentTime = Carbon::now(env('CINEMA_TIMEZONE'));


        $times = Time::whereNull('deleted_at')
            ->where('label', '<', (clone $currentTime)->addHours(2)->format('H:i'))
            ->where('label', '>', (clone $currentTime)->format('H:i'))
            ->get();


        $time_ids = $times->pluck('id');


        $shows_ids = MovieShow::whereNull('deleted_at')
            ->whereDate('date', $today)
            ->whereIn('time_id', $time_ids)
            ->orderBy('movie_id')
            ->pluck('id');


        $reservedSeats = ReservedSeat::whereNull('deleted_at')
            ->whereIn('movie_show_id', $shows_ids)
            ->count();





        return $this->responseData(
            [
                'count' => $reservedSeats
            ]
        );
    }

    public function PosGetLastOrderInfoforCashier()
    {

        $user = request()->user;
        $user_type = request()->user_type;



        try {
            $order = $this->orderRepository->getPosuserLastOrder($user->id);
        } catch (\Exception $e) {
            return $this->response(notification()->error('No orders found for the cashier.', $e->getMessage()));
        }


        return $this->details($order);



        try {
            $order_seats = $this->orderRepository->getOrderSeats($order->id);
        } catch (\Exception $e) {

            return $this->response(notification()->error('No seats found for the order.', $e->getMessage()));
        }

        $order_seats = $order_seats->map(function ($order_seat) {
            return [
                'label' => $order_seat->label,
                'seat' => $order_seat->seat,
                'price' => currency_format($order_seat->price),
                'discount' => currency_format($order_seat->discount),
                'final_price' => currency_format($order_seat->price - $order_seat->discount),
                'gained_points' => $order_seat->gained_points,
                'show_details' => [
                    'movie_name' => $order_seat->movie->name ?? '',
                    'theater' => $order_seat->theater->hall_number ?? '',
                    'showdate' => now()->parse($order_seat->date)->format('d M, Y') ?? '',
                    'showtime' => isset($order_seat->time->label) ? convertTo12HourFormat($order_seat->time->label) : ''
                ]
            ];
        });


        // return $this->responseData([
        //     'order_id' => $order["order_id"],
        //     ...$this->details($order["order_id"], false),
        // ], notification()->success('Order completed', 'Your order has been successfully completed'));

        return $this->responseData([
            'order_id' => $order->id,
            'order_seats' => $order_seats,
        ]);
    }
}
