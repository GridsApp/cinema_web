<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\MovieShow;
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
    public function listHistory()
    {
        $user = request()->user;

        $order_seats = OrderSeat::whereNull('order_seats.deleted_at')
            ->join('orders', 'orders.id', 'order_seats.order_id')
            ->where('orders.user_id', $user->id)
            ->whereNull('order_seats.refunded_at')
            ->get()
            ->groupBy('movie_show_id');

        if ($order_seats->isEmpty()) {
            return $this->response(notification()->error('No Order Found', 'No Order Found'));
        }
        $order_seats = $order_seats->map(function ($seats, $movie_show_id) {
            $movieShow = $seats->pluck('movieShow')->first();
            $movie_image = get_image($movieShow->movie->main_image);

            $show_datetime = now()->parse($movieShow->date . ' ' . $movieShow->time->label);

            if (!$show_datetime->isToday() && !$show_datetime->isBefore(now())) {
                return null;
            }

            return [
                'movie_name' => $movieShow->movie->name ?? '',
                'movie_image' => $movie_image ?? '',
                'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
                'showtime' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : '',
                'branch' => $movieShow->theater->branch->label ?? '',
                'theater' => $movieShow->theater->label ?? '',
                'seats' => $seats->pluck('seat')->implode(","),
            ];
        })->filter()->values();


        return $this->responseData($order_seats);
    }

    public function upcoming()
    {
        $user = request()->user;

        $order_seats = OrderSeat::whereNull('order_seats.deleted_at')
            ->join('orders', 'orders.id', 'order_seats.order_id')
            ->where('orders.user_id', $user->id)
            ->whereNull('order_seats.refunded_at')
            ->get()
            ->groupBy('movie_show_id');


        if ($order_seats->isEmpty()) {
            return $this->response(notification()->error('No upcomming orders found', 'No upcomming orders found'));
        }
        $order_seats = $order_seats->map(function ($seats, $movie_show_id) {

            $movieShow = $seats->pluck('movieShow')->first();
            $movie_image = get_image($movieShow->movie->main_image);

            $show_datetime = now()->parse($movieShow->date . ' ' . $movieShow->time->label);

            if (!$show_datetime->isFuture()) {
                return null;
            }

            return [
                'movie_name' => $movieShow->movie->name ?? '',
                'movie_image' => $movie_image ?? '',
                'showdate' => now()->parse($movieShow->date)->format('d M, Y') ?? '',
                'showtime' => isset($movieShow->time->label) ? convertTo12HourFormat($movieShow->time->label) : '',
                'branch' => $movieShow->theater->branch->label ?? '',
                'theater' => $movieShow->theater->label ?? '',
                'seats' => $seats->pluck('seat')->implode(","),
            ];
        })->filter()->values();

        return $this->responseData($order_seats);
    }
}
