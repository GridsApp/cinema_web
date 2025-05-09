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
        $this->addFilter('filter_ticket_status');
        $this->addFilter('filter_pos_user');
        $this->addFilter('filter_reference');
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


    public function rows()
    {

      
        if (!$this->filterResults) {
            return;
        }

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
                'branches.condensed_name as branch_condensed',
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
            ->when($this->filterResults['branch_id'] ?? null, fn($q, $value) => $q->where('orders.branch_id', $value))
            ->when($this->filterResults['movie_id'] ?? null, fn($q, $value) => $q->where('order_seats.movie_id', $value))
            ->when($this->filterResults['time_id'] ?? null, fn($q, $value) => $q->where('order_seats.time_id', $value))
            ->when($this->filterResults['system_id'] ?? null, fn($q, $value) => $q->where('orders.system_id', $value))
            ->when($this->filterResults['payment_method_id'] ?? null, fn($q, $value) => $q->where('orders.payment_method_id', $value))
            ->when($this->filterResults['reference'] ?? null, fn($q, $value) => $q->where('orders.reference', 'like', "%$value%"))
            ->when($this->filterResults['ticket_status'] ?? null, function ($q, $value) {
                if ($value === 'refunded_tickets') {
                    $q->whereNotNull('order_seats.refunded_at');
                } elseif ($value === 'sold_tickets') {
                    $q->whereNull('order_seats.refunded_at');
                }
            })
            ->when($this->filterResults['pos_user_id'] ?? null, fn($q, $value) => $q->where('orders.pos_user_id', $value))
            ->when(
                $this->filterResults['phone'] ?? null,
                fn($q, $phone) =>

                $q->where('customers.phone',  $phone)


            )
            ->when(
                $this->filterResults['amount_min'] ?? null,
                fn($q, $value) =>
                $q->havingRaw('unit_price * seats_count >= ?', [(float)$value])
            )
            ->when(
                $this->filterResults['amount_max'] ?? null,
                fn($q, $value) =>
                $q->havingRaw('unit_price * seats_count <= ?', [(float)$value])
            )

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
                'time' => $row->time ?? '-',
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'theater' => $row->theater ?? '-',
                'booked_by' => $row->booked_by ?? '-',
                'refunded_by' => $row->refunded_by ?? '-',
                'refunded_by_manager' => $row->refunded_by_manager ?? '-',
                'status' => $isRefunded ? 'Refunded Tickets' : 'Sold Tickets',
                'system' => $row->system ?? '-',
                'payment_method' => $row->payment_method ?? '-',
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
