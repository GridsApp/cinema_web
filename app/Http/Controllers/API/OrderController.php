<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentAttempt;
use App\Models\Theater;
use App\Repositories\CardRepository;
use App\Repositories\MovieShowRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TheaterRepository;
use App\Traits\APITrait;
use Illuminate\Http\Request;
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


    public function __construct(OrderRepositoryInterface $orderRepository, MovieShowRepository $movieShowRepository, TheaterRepositoryInterface $theaterRepository, CartRepositoryInterface $cartRepository, PosUserRepositoryInterface $posUserRepository, CardRepositoryInterface $cardRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->theaterRepository = $theaterRepository;
        $this->cartRepository = $cartRepository;
        $this->posUserRepository = $posUserRepository;
        $this->cardRepository = $cardRepository;
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
            return $this->response(notification()->error('Order not foun', $e->getMessage()));
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

    // public function refund()
    // {

    //     $form_data = clean_request([]);

    //     $validator = Validator::make($form_data, [
    //         'order_id' => 'required',
    //         'order_seat_id' => 'required',
    //         // 'branch_id' => 'required',
    //         'manager_pin'=> 'required',
    //         'manager_id' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->responseValidation($validator);
    //     }


    //     try {
    //         $user_id = request()->user->id;
    //         $user_type = request()->user_type;
    //         $field = get_user_field_from_type($user_type);
    //         // $order = Order::findOrFail($order_id);

    //         $order_seats = $this->orderRepository->getOrderSeats($form_data['order_id'], $form_data['order_seat_id']);
    //         if (!isset($order_seats) || $order_seats->isEmpty()) {
    //             throw new \Exception("No matching order seats found for the given order ID {$form_data['order_id']} and seat ID {$form_data['order_seat_id']}.");
    //         }
    //         $total_amount = 0;
    //         $total_points = 0;


    //         $managers = $this->posUserRepository->getManagerByPin($form_data['manager_pin'],$form_data['manager_id']);

    //         foreach ($order_seats as $order_seat) {
    //             $order_seat->refunded_at = now();
    //             $order_seat->refunded_cashier_id = $user_id;
    //             if (isset($managers)  && $managers->isNotEmpty()) {
    //                 $order_seat->refunded_manager_id = $managers->last()['id'];
    //             }

    //             // $total_points += $order_seat->gained_points;
    //             // $total_amount += $order_seat->price;

    //             $order_seat->save();
    //         }


    //         // $this->orderRepository->refundOrderSeats(
    //         //     $form_data['order_id'],
    //         //     $form_data['order_seat_id'],
    //         //     $form_data['branch_id'],
    //         //     $user_id,
    //         //     $user_type,
    //         //     $field

    //         // );


    //         //if not cash
    //         //out // 
    //         //in total_amount        

    //         return $this->response(notification()->success('Refund Successful', 'Refund Successful'));
    //     } catch (\Exception $e) {

    //         return $this->response(notification()->error('Refund Failed', $e->getMessage()));
    //     }
    // }
    public function refund()
    {
        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'order_id' => 'required',
            'order_seat_id' => 'required',
            'manager_pin' => 'required',
            'manager_id' => 'required'
        ]);
        $order_id = $form_data['order_id'];

        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }

        try {
            $user_id = request()->user->id;
            $user_type = request()->user_type;
            $field = get_user_field_from_type($user_type);
            $user_branch = request()->user->branch_id;
            $order = Order::findOrFail($order_id);
            // dd($order);
            $total_amount = 0;
            $total_points = 0;
            $order_seats = $this->orderRepository->getOrderSeats($form_data['order_id'], $form_data['order_seat_id']);
            if (!isset($order_seats) || $order_seats->isEmpty()) {
                throw new \Exception("No matching order seats found for the given order ID {$form_data['order_id']} and seat ID {$form_data['order_seat_id']}.");
            }
            try {
                $managers = $this->posUserRepository->getManagersByPin($form_data['manager_id'], $form_data['manager_pin'], $user_branch);

                if ($managers->isEmpty()) {
                    return $this->response(notification()->error('Refund Failed', 'No matching manager found.'));
                }
            } catch (\Throwable $th) {
                return $this->response(notification()->error('Refund Failed', $th->getMessage()));
            }
            foreach ($managers as $manager) {
                foreach ($order_seats as $order_seat) {
                    // dd($total_amount += $order_seat->price);
                    $order_seat->refunded_at = now();
                    $order_seat->refunded_cashier_id = $user_id;
                    $order_seat->refunded_manager_id = $manager->id;
                    $total_points += $order_seat->gained_points;
                    $total_amount += $order_seat->price;
                    $order_seat->save();
                }
            }
            if ($order->payment_method_id == 2) {
                return $this->response(notification()->success('cash', 'Cash.'));
            }

            $payment_method = $order->paymentMethod;
            if ($payment_method) {
                $user = $order->user;
                // dd($user);
                if (!$user) {
                    throw new \Exception("User associated with the order seats not found.");
                }

                $this->cardRepository->createWalletTransaction("in", $total_amount, $user, "Recharge wallet");

            }
            return $this->response(notification()->success('Refund Successful', 'Refund Successful'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Refund Failed', $e->getMessage()));
        }
    }
}
