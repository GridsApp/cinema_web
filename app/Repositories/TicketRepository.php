<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Order;
use App\Traits\APITrait;

class TicketRepository implements TicketRepositoryInterface
{ 

    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,

    ) {
        $this->orderRepository = $orderRepository;
    }

    public function getTickets($user)
    {



        // $user_balance = $this->cardRepository->getLoyaltyBalance($user);

        // $used_rewards = $this->getUsedRewards($user->id);

        // $rewards = Reward::all();
        // $reward_list = $rewards->map(function ($reward) use ($user_balance , $used_rewards) {
        //     $redeem_points = $reward->redeem_points;

        //     $percrentage = ($user_balance  / $redeem_points  ) * 100;
        //     $percrentage = $percrentage > 100 ? 100 : $percrentage;

        //     return [
        //         'id' => $reward->id,
        //         'title' => $reward->title,
        //         'redeem_points' => $redeem_points,
        //         'image' => get_image($reward->image),
        //         'description' => $reward->description,
        //         'one_time_usage' => $reward->one_time_usage,
        //         'percentage' => $percrentage,
        //         'remaining_points' => $percrentage == 100 ? 0 : $redeem_points - $user_balance,
        //         'code' => $used_rewards[$reward->id] ?? null,
        //         'user_balance' => (double) $user_balance
        //     ];
        // });
        // return $list;
    }

    // public function getUserTickets($user_id)
    // {
 

    //     try {
    //         // $order = $this->orderRepository->getOrderByUserId($user_id);
 
    //   return $order;
    //     } catch (\Exception $e) {
    //         return $this->response(notification()->error('Order not found', $e->getMessage()));
    //     }

    //     // $order_seats = OrderSeat::whereNull('deleted_at')
    //     //     ->where('order_id', $order->id)
    //     //     ->whereNull('refunded_at')
    //     //     ->get()
    //     //     ->map(function ($order_seat) {

    //     //         $movieShow = $order_seat->movieShow;


    //     //         return [
    //     //             'label' => $order_seat->label,
    //     //             'seat' => $order_seat->seat,
    //     //             'price' => currency_format($order_seat->price),
    //     //             'discount' => currency_format($order_seat->discount),
    //     //             'final_price' => currency_format($order_seat->final_price),
    //     //             'gained_points' => $order_seat->gained_points,
    //     //             'show_details' => [
    //     //                 'movie_name' => $movieShow->movie->name ?? '',
    //     //                 'theater' => $movieShow->theater->hall_number ?? '',
    //     //                 'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
    //     //                 'showtime' => isset($movieShow->time->iso) ? convertTo12HourFormat($movieShow->time->iso) : ''
    //     //             ]
    //     //         ];
    //     //     });








        // return $this->responseData([
        //     'order' => [
        //         'id' => $order->id,
        //         'reference' => $order->reference,
        //         'barcode' => $order->barcode,
        //         'system' => $order->system->label ?? '',
        //         'payment_method' => $order->paymentMethod->label ?? '',
        //         'user' => $order->user?->only(['id', 'full_name', 'phone', 'email']),
        //         'cashier' => $order->posUser?->only(['id', 'name']),
        //         'order_date' => now()->parse($order->created_at)->format('d M, Y H:i:s'),
        //         'printed' => $order->printed
        //     ],
        //     'seat' => $order_seats,

        // ]);

        // return  Order::whereNull('deleted_at')->where('user_id', $user_id)->get();
    // }
}
