<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentAttempt;
use App\Repositories\MovieShowRepository;
use App\Traits\APITrait;
use Illuminate\Support\Facades\Validator;


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


    public function __construct(OrderRepositoryInterface $orderRepository, MovieShowRepository $movieShowRepository, TheaterRepositoryInterface $theaterRepository, CartRepositoryInterface $cartRepository, PosUserRepositoryInterface $posUserRepository, CardRepositoryInterface $cardRepository, ZoneRepositoryInterface $zoneRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->theaterRepository = $theaterRepository;
        $this->cartRepository = $cartRepository;
        $this->posUserRepository = $posUserRepository;
        $this->cardRepository = $cardRepository;
        $this->zoneRepository = $zoneRepository;
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



        try {
            $cart = $this->cartRepository->getCartById($form_data['cart_id']);
            $cart = $this->cartRepository->getCartDetails($cart);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Cart Error', $e->getMessage()));
        }

        $subtotal = $cart['subtotal']['value'];

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

        return $this->responseData([
            'redirect' => route("payment.initialize", [
                'payment_attempt_id' => $payment_attempt->id,
                'token' => $token
            ])
        ]);
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
            // return $zones;
            $order_seats = $order_seats->map(function ($order_seat) use ($zones) {
                $zone = $zones[$order_seat['zone_id']];
                if (!$zone) {
                    return null;
                }

                $unit_price = $zone->price;
// $final_
                return [
                    'id' => $order_seat['order_id'],
                    'type' => "Seat",
                    'label' => $zone->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_seat['quantity'],
                    'price' => currency_format($unit_price * $order_seat['quantity']),
                ];
            })->filter();

            $total = $order_seats->sum('price.value');
            return $order_seats;
            // $total = $order->seats->sum('final_price');

            // $lines = collect([]);

            // $lines = $lines->merge($order->seats->map(function ($seat) {
            //     return [
            //         'label' => $seat->label,
            //         'qualtity' => 1,
            //         'price' => currency_format($seat->final_price),
            //     ];
            // }));




            $lines = $lines->merge($order->items->map(function ($item) {
                return [
                    'label' => $item->label,
                    'qualtity' => 1,
                    'price' => currency_format($item->price),
                ];
            }));

            $lines = $lines->merge($order->topups->map(function ($topup) {
                return [
                    'label' => $topup->label,
                    'qualtity' => 1,
                    'price' => currency_format($topup->amount),
                ];
            }));



            return [
                'order_id' => $order->id,
                'date' => $order->created_at,
                'quantity' => $order->seats->count(),
                'total_price' => currency_format($total),
                'lines' => $lines

            ];
        });
        return $this->responseData($orders);

        // $order_seats = OrderSeat::whereNull('order_seats.deleted_at')
        //     ->join('orders', 'orders.id', 'order_seats.order_id')
        //     ->where('orders.user_id', $user->id)
        //     ->whereNull('order_seats.refunded_at')
        //     ->get();
        // ->groupBy('movie_show_id');

        // if ($order_seats->isEmpty()) {
        //     return $this->response(notification()->error('No Order Found', 'No Order Found'));
        // }
        // $order_seats = $order_seats->map(function ($seats, $movie_show_id) {
        //     $movieShow = $seats->pluck('movieShow')->first();
        //     $movie_image = get_image($movieShow->movie->main_image);

        //     $show_datetime = now()->parse($movieShow->date . ' ' . $movieShow->time->label);

        //     if (!$show_datetime->isToday() && !$show_datetime->isBefore(now())) {
        //         return null;
        //     }

        //     return [
        //         'movie_name' => $movieShow->movie->name ?? '',
        //         'movie_image' => $movie_image ?? '',
        //         'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
        //         'showtime' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : '',
        //         'branch' => $movieShow->theater->branch->label ?? '',
        //         'theater' => $movieShow->theater->label ?? '',
        //         'seats' => $seats->pluck('seat')->implode(","),
        //     ];
        // })->filter()->values();



    }
}
