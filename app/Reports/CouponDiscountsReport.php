<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class CouponDiscountsReport extends DefaultReport
{

    public $label = "Coupon Discounts";
    public $pagination = 100;


    public function filters()
    {

        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_movie');
        $this->addFilter('filter_payment_method');
        $this->addFilter('filter_system');
        $this->addFilter('filter_pos_user');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }
        $this->addColumn("created_at", "Booking Time");
        $this->addColumn("reference", "Reference");
        $this->addColumn("movie", "Movie");
        $this->addColumn("branch", "Branch");
        $this->addColumn("payment_method", "Payment Method");
        $this->addColumn("system", "System");
        $this->addColumn("booked_by", "Booked By");
        $this->addColumn("coupon_label", "Coupon Source");
        $this->addColumn("coupon_code", "Coupon Code");
        $this->addColumn("coupon_discount", "Coupon Discount");
        $this->addColumn("seats", "Seats");
        $this->addColumn("seats_count", "# Seats");
        $this->addColumn("type", "Price Group");
    }




    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $start_date = $this->filterResults['start_date'] ?? null;
        $end_date = $this->filterResults['end_date'] ?? null;
        $branch = $this->filterResults['branch_id'] ?? null;
        $movie = $this->filterResults['movie_id'] ?? null;
        $paymentMethod = $this->filterResults['payment_method_id'] ?? null;
        $system = $this->filterResults['system_id'] ?? null;
        $posUser = $this->filterResults['pos_user_id'] ?? null;

        $dateRange = ($start_date && $end_date)
            ? [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]
            : null;

        $footer = collect([
            'created_at' => 'Total',
            'reference' => '-',
            'movie' => '-',
            'branch' => '-',
            'payment_method' => '-',
            'system' => '-',
            'booked_by' => '-',
            'coupon_label' => '-',
            'coupon_code' => '-',
            'coupon_discount' => 0,
            'seats' => '-',
            'seats_count' => '-',
            'type' => '-',

        ]);

        $query = DB::table('order_coupons')
            ->join('orders', 'order_coupons.order_id', '=', 'orders.id')
            ->leftJoin('order_seats', 'orders.id', '=', 'order_seats.order_id')
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('coupons', 'order_coupons.coupon_id', '=', 'coupons.id')
            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')

            ->select([
                'orders.id as order_id',
                'orders.reference',
                'movies.name as movie',
                'movies.condensed_name as condensed_movie',
                'order_seats.label as type',
                'pos_users.name as booked_by',
                'branches.label_en as branch',
                'branches.condensed_name as branch_condensed',
                'payment_methods.label as payment_method',

                DB::raw('SUM(order_coupons.amount) as coupon_discount'),
                DB::raw("GROUP_CONCAT(DISTINCT coupons.label SEPARATOR ', ') as coupon_labels"),
                DB::raw("GROUP_CONCAT(DISTINCT coupons.code SEPARATOR ', ') as coupon_codes"),
                DB::raw('COUNT(DISTINCT order_seats.id) as seats_count'),
                DB::raw("GROUP_CONCAT(DISTINCT order_seats.seat ORDER BY order_seats.seat ASC SEPARATOR ', ') as seats"),
                DB::raw("GROUP_CONCAT(DISTINCT order_seats.label ORDER BY order_seats.label ASC SEPARATOR ', ') as types"),
                DB::raw("CONCAT(orders.reference) as computed_identifier"),

                'order_coupons.created_at',
                'systems.label as system',
            ])
            ->whereNull('order_coupons.deleted_at');

        if ($dateRange) {
            $query->whereBetween('order_coupons.created_at', $dateRange);
        }

        if ($branch) {
            $query->where('orders.branch_id', $branch);
        }

        if ($movie) {
            $query->where('order_seats.movie_id', $movie);
        }

        if ($paymentMethod) {
            $query->where('orders.payment_method_id', $paymentMethod);
        }

        if ($system) {
            $query->where('orders.system_id', $system);
        }

        if ($posUser) {
            $query->where('orders.pos_user_id', $posUser);
        }
        $results = $query->groupBy('computed_identifier')->get();


        $rows = $results->map(function ($row) use (&$footer) {
            // $unit_price = $row->unit_price;
            // $seats_count = $row->seats_count;
            // $total_price = $unit_price * $items_count;

            $createdAt = Carbon::parse($row->created_at);

            $data = [

                'created_at' => $createdAt->format('d-m-Y'),
                'reference' => $row->reference,
                'movie' => !empty($row->movie_condensed) ? $row->movie_condensed : $row->movie,
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'payment_method' => $row->payment_method ?? '',
                'system' => $row->system ?? '-',
                'booked_by' => $row->booked_by ?? '-',
                'coupon_label' => $row->coupon_labels,
                'coupon_code' => $row->coupon_codes,
                'coupon_discount' => $row->coupon_discount,
                'seats' => $row->seats ?? '-',
                'seats_count' => $row->seats_count ?? 0,
                'type' => $row->types ?? '-',

            ];

            $footer['coupon_discount'] += $data['coupon_discount'];

            $data['coupon_discount'] = number_format($data['coupon_discount']);

            return $data;
        })->filter()->values();

        $footer['coupon_discount'] = number_format($footer['coupon_discount']);


        $this->setFooter($footer);

        return $rows;
    }



    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
