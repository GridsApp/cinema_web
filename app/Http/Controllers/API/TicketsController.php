<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\OrderSeat;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Transport\Dsn;

class TicketsController extends Controller
{
    use APITrait;


    private TicketRepositoryInterface $ticketRepository;
    private OrderRepositoryInterface $orderRepository;


    public function __construct(TicketRepositoryInterface $ticketRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->orderRepository = $orderRepository;
    }
    public function list()
    {

        $user = request()->user;
        try {
            $order = $this->orderRepository->getOrderByUserId($user->id);

            // return $order;
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order not found', $e->getMessage()));
        }

        $order_seats = OrderSeat::whereNull('deleted_at')
            ->where('order_id', $order->id)
            ->whereNull('refunded_at')
            ->get()
            ->groupBy('movie_show_id')
            ->map(function ($order_seats) {

                $order_seat = $order_seats[0] ?? null;

                if (!$order_seat) {
                    return null;
                }

                $movieShow = $order_seat->movieShow;
                dd($movieShow);

                return [
                    // 'label' => $order_seat->label,

                    // 'price' => currency_format($order_seat->price),
                    // 'discount' => currency_format($order_seat->discount),
                    // 'final_price' => currency_format($order_seat->final_price),
                    // 'gained_points' => $order_seat->gained_points,

                    'movie_name' => $movieShow->movie->name ?? '',
                    'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
                    'showtime' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : '',
                    'branch' => $movieShow->theater->branch->label ?? '',
                    'theater' => $movieShow->theater->label ?? '',
                    'seats' => $order_seats->pluck('seat')->implode(","),

                ];
            })->filter()->values();



        return $this->responseData($order_seats);
    }
}
