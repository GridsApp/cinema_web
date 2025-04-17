<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class OrderTicketsReport extends DefaultReport
{

    public $label = "Order Tickets";



    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_movie');

        $this->addFilter('filter_time');

        $this->addFilter('filter_system');
        $this->addFilter('filter_payment_method');
        $this->addFilter('filter_reference');
        $this->addFilter('filter_ticket_status');

        $this->addFilter('filter_pos_user');
        $this->addFilter('filter_user_phone');
        $this->addFilter('filter_amount_min');
        $this->addFilter('filter_amount_max');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("created_at", "Created at");
        $this->addColumn("customer_name", "Customer");
        $this->addColumn("reference", "Reference");
        $this->addColumn("type", "Type");
        $this->addColumn("unit_price", "Price/Ticket");
        $this->addColumn("seats", "Seats");
        $this->addColumn("nb_seats", "Total Seats");
        $this->addColumn("total_price", "Tickets Amount");
        // $this->addColumn("refund_amount", "Refund Amount");
        $this->addColumn("movie", "Movie");
        $this->addColumn("date", "Show Date");
        $this->addColumn("time", "Show Time");
        $this->addColumn("branch", "Branch");
        $this->addColumn("theater", "Theater");
        $this->addColumn("booked_by", "Booked By");
        $this->addColumn("refunded_by", "Refunded Cashier");
        $this->addColumn("refunded_by_manager", "Refunded Manager");
        $this->addColumn("status", "Ticket Status");
        $this->addColumn("system", "Booked Via");
        $this->addColumn("payment_method", "Payment Method");
    }


    // public function rows()
    // {
    //     if (!$this->filterResults) {
    //         return;
    //     }

    //     $start_date = $this->filterResults['start_date'] ?? null;
    //     $end_date = $this->filterResults['end_date'] ?? null;

    //     $dateRange = null;

    //     if ($start_date && $end_date) {
    //         $dateRange = [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()];
    //     }

    //     $footer = [
    //         'created_at' =>  'Total',
    //         'customer_name' => '-',
    //         'reference' => '-',
    //         'type' => '-',
    //         'unit_price' => '-',
    //         'seats' => '-',
    //         'nb_seats' => 0,
    //         'total_price' => 0,
    //         'refund_amount' => 0,
    //         'movie' => '-',
    //         'date' => '-',
    //         'time' => '-',
    //         'branch' => '-',
    //         'theater' => '-',
    //         'created_by' => '-',
    //         'refunded_by' => '-',
    //         'refunded_by_manager' => '-',
    //         'status' => '-',
    //         'system' => '-',
    //         'payment_method' => '-',

    //     ];

    //     // $booked_seats = OrderSeat::query()
    //     //     ->join('orders', 'order_seats.order_id', '=', 'orders.id')
    //     //     ->select(
    //     //         // 'order_seats.*',
    //     //         // 'orders.branch_id',

    //     //         'orders.reference',
    //     //         DB::raw('COUNT(*) as seats_count'),

    //     //         DB::raw("GROUP_CONCAT(seat) as seats"),

    //     //         DB::raw("CONCAT(order_seats.zone_id,'_' , orders.reference) as identifier")
    //     //     )
    //     //     ->whereNull('order_seats.deleted_at');

    //     // if ($dateRange) {
    //     //     $booked_seats->whereBetween('order_seats.date', $dateRange);
    //     // };
    //     // $booked_seats = $booked_seats->groupBy('identifier')

    //     //     ->get();

    //     $baseQuery = OrderSeat::with('movie.distributor', 'zone')
    //         ->join('orders', 'order_seats.order_id', '=', 'orders.id')
    //         ->select(
    //             'orders.reference',
    //             'orders.user_id',
    //             'orders.branch_id',
    //             'orders.pos_user_id',
    //             'orders.payment_method_id',
    //             'order_seats.*',
    //             DB::raw('COUNT(*) as seats_count'),
    //             DB::raw("GROUP_CONCAT(seat) as seats"),
    //             DB::raw("CONCAT(order_seats.zone_id,'_',orders.reference) as identifier")
    //         );
    //     if ($dateRange) {
    //         $baseQuery->whereBetween('order_seats.date', $dateRange);
    //     };
    //     $baseQuery = $baseQuery->groupBy('identifier');

    //     $notRefunded = (clone $baseQuery)
    //         ->whereNull('order_seats.refunded_at')
    //         ->whereNull('order_seats.deleted_at');


    //     $refunded = (clone $baseQuery)
    //         ->whereNotNull('order_seats.refunded_at')
    //         ->whereNull('order_seats.deleted_at');

    //     $results = $notRefunded->union($refunded)->get()
    //         ->map(function ($order_seats) use (&$footer) {
    //             $isRefunded = $order_seats->refunded_at !== null;
    //             $unit_price = $order_seats->price;
    //             $seats_count = $order_seats->seats_count;
    //             $total_price = $unit_price * $seats_count;
    //             if ($isRefunded) {
    //                 $total_price *= -1;
    //             }
    //             $data = [
    //                 'created_at' => Carbon::parse($order_seats->created_at)->format('d-m-Y H:i:s'),
    //                 'customer_name' => $order_seats->order?->user->name ?? '',
    //                 'reference' => $order_seats->reference,
    //                 'type' => $order_seats->label,
    //                 'unit_price' => $unit_price,
    //                 'seats' => $order_seats->seats,
    //                 'nb_seats' => $seats_count,
    //                 'total_price' => $total_price,
    //                 'refund_amount' => $order_seats->refunded_at ? $unit_price * $seats_count : 0,
    //                 'movie' => $order_seats->movie->name ?? '',
    //                 'date' => $order_seats->date,
    //                 'time' => optional($order_seats->time)->label ?? '',
    //                 'branch' => $order_seats->order?->branch->label_en ?? '',
    //                 'theater' => optional($order_seats->theater)->label ?? '',
    //                 'booked_by' => $order_seats->order->posUser->name,
    //                 'refunded_by' => $order_seats->refundedCashier->name ?? '',
    //                 'refunded_by_manager' => $order_seats->refundedManager->name ?? '',
    //                 'status' => $order_seats->refunded_at ? 'Refunded Tickets' : 'Sold Tickets',
    //                 'system' => $order_seats->order?->system->label,
    //                 'payment_method' => optional($order_seats->order?->paymentMethod)->label ?? '',
    //             ];
    //             $footer['nb_seats'] += $data['nb_seats'];
    //             $footer['total_price'] += $data['total_price'];
    //             $footer['refund_amount'] += $data['refund_amount'];

    //             $data['unit_price'] = number_format($data['unit_price']);
    //             $data['total_price'] = number_format($data['total_price']);
    //             $data['refund_amount'] = number_format($data['refund_amount']);


    //             return $data;
    //         })->filter()->values();

    //     $footer['nb_seats'] = number_format($footer['nb_seats']);
    //     $footer['total_price'] = number_format($footer['total_price']);
    //     $footer['refund_amount'] = number_format($footer['refund_amount']);
    //     $this->setFooter($footer);

    //     return $results;
    // }

    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $start_date = $this->filterResults['start_date'] ?? null;
        $end_date = $this->filterResults['end_date'] ?? null;

        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;


        $footer = [
            'created_at' => 'Total',
            'customer_name' => '-',
            'reference' => '-',
            'type' => '-',
            'unit_price' => '-',
            'seats' => '-',
            'nb_seats' => 0,
            'total_price' => 0,
            'refund_amount' => 0,
            'movie' => '-',
            'date' => '-',
            'time' => '-',
            'branch' => '-',
            'theater' => '-',
            'booked_by' => '-',
            'refunded_by' => '-',
            'refunded_by_manager' => '-',
            'status' => '-',
            'system' => '-',
            'payment_method' => '-',
        ];


        $baseQuery = DB::table('order_seats')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')
            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('price_group_zones as zones', 'order_seats.zone_id', '=', 'zones.id')
            ->leftJoin('theaters', 'order_seats.theater_id', '=', 'theaters.id')
            ->leftJoin('pos_users as refunded_by_user', 'order_seats.refunded_cashier_id', '=', 'refunded_by_user.id')
            ->leftJoin('pos_users as refunded_manager_user', 'order_seats.refunded_manager_id', '=', 'refunded_manager_user.id')
            ->leftJoin('times', 'order_seats.time_id', '=', 'times.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
            ->select([
                'orders.id as order_id',
                'orders.reference',
                'order_seats.id',
                'orders.user_id',
                'customers.name as customer_name',
                'orders.pos_user_id',
                'pos_users.name as booked_by',
                'orders.branch_id',
                'branches.label_en as branch',
                'orders.payment_method_id',
                'payment_methods.label as payment_method',
                'order_seats.price as unit_price',

                DB::raw('COUNT(*) as seats_count'),
                DB::raw("GROUP_CONCAT(seat) as seats"),
                DB::raw("CONCAT(order_seats.zone_id,'_',orders.reference) as computed_identifier"),

                'order_seats.label as type',
                'movies.name as movie',
                'zones.label as zone_label',
                'order_seats.date',
                'times.label as time',
                'theaters.label as theater',
                'order_seats.created_at',
                'order_seats.refunded_at',
                'refunded_by_user.name as refunded_by',
                'refunded_manager_user.name as refunded_by_manager',
                'systems.label as system',
            ])
            ->when($dateRange, fn($q) => $q->whereBetween('order_seats.date', $dateRange))
            ->whereNull('order_seats.deleted_at')
            ->orderBy('id', 'ASC')
            ->groupBy('computed_identifier');


        $notRefunded = (clone $baseQuery)->selectRaw("'0' as refunded");
        $refunded = (clone $baseQuery)->selectRaw("'1' as refunded")->whereNotNull('order_seats.refunded_at');

        $results = $notRefunded->union($refunded)->get()->sortBy('order_id');
        $rows = $results->map(function ($row) use (&$footer) {

           

            $isRefunded = $row->refunded == '1';
            $unit_price = $row->unit_price;
            $seats_count = $row->seats_count;
            $total_price = $unit_price * $seats_count;

            if ($isRefunded) {
                $total_price *= -1;
            }

            if ($isRefunded) {
                $seats_count *= -1;
            }

            $refund_amount = $isRefunded ? ($unit_price * $seats_count) : 0;
            $data = [
                'created_at' => Carbon::parse($row->created_at)->format('d-m-Y H:i'),
                'customer_name' => $row->customer_name ?? '',
                'reference' => $row->reference,
                'type' => $row->type,
                'unit_price' => number_format($unit_price),
                'seats' => $row->seats,
                'nb_seats' => $seats_count,
                'total_price' => number_format($total_price),
                'refund_amount' => number_format(abs($refund_amount)),
                'movie' => $row->movie,
                'date' => $row->date,
                'time' => $row->time ?? '',
                'branch' => $row->branch ?? '',
                'theater' => $row->theater ?? '',
                'booked_by' => $row->booked_by,
                'refunded_by' => $row->refunded_by,
                'refunded_by_manager' => $row->refunded_by_manager,
                'status' => $isRefunded ? 'Refunded Tickets' : 'Sold Tickets',
                'system' => $row->system ?? '',
                'payment_method' => $row->payment_method ?? '',
            ];


            $footer['nb_seats'] += $seats_count;
            $footer['total_price'] += $total_price;
            $footer['refund_amount'] += $refund_amount;

            return $data;
        })->filter()->values();

        $footer['nb_seats'] = number_format($footer['nb_seats']);
        $footer['total_price'] = number_format($footer['total_price']);
        $footer['refund_amount'] = number_format($footer['refund_amount']);

        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
