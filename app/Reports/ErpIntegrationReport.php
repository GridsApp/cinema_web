<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class ErpIntegrationReport extends DefaultReport
{

    public $label = "ERP Excel";



    public function filters()
    {
        $this->addFilter('filter_date');
        $this->addFilter('filter_date_type');
        $this->addFilter('filter_branch');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }



        $this->addColumn("movie_key", "IMDB Code");
        $this->addColumn("movie", "Movie Name");
        $this->addColumn("distributor_name", "Distributor Name");
        $this->addColumn("branch", "Branch");
        $this->addColumn("reference", "Order Number");
        $this->addColumn("theater", "Hall #");
        $this->addColumn("type", "Movie Type");
        $this->addColumn("seats", "Seat#");
        $this->addColumn("nb_seats", "Count");
        $this->addColumn("Week #", "Wk#");
        $this->addColumn("movie_show_date", "Movie Show Date");
        $this->addColumn("movie_show_time", "Movie Show Time");
        $this->addColumn("booking_date", "Booking Date");
        $this->addColumn("booking_time", "Booking Time");
        $this->addColumn("unit_price", "Unit Price");
        $this->addColumn("total_price", "Total Price");
        $this->addColumn("imtiyaz_discount", "Imtiyaz Discount");
        $this->addColumn("customer_name", "Customer");
        $this->addColumn("cashier", "Station");
        $this->addColumn("booked_via", "Booked Via");
        $this->addColumn("payment_method", "Payment Mode");
        $this->addColumn("tax_amount", "Tax 5%");
        $this->addColumn("dist_perc", "Dist. %");
        $this->addColumn("cost_of_sale", "Total Cost Of Sale");
        $this->addColumn("unit_cost", "Unit Cost");
    }



    public function rows()
    {


        if (!$this->filterResults) {
            return;
        }
        $date = $this->filterResults['date'] ?? null;
        $date_type = $this->filterResults['date_type'] ?? 'range';
        $branch_id = $this->filterResults['branch_id'] ?? null;


        $dateRange = null;

        if ($date) {
            if ($date_type === 'single') {
                $start = Carbon::parse($date)->startOfDay();
                $end = Carbon::parse($date)->endOfDay();
            } else {
                $range = get_range_date($date);
                $start = $range['start']->startOfDay();
                $end = $range['end']->endOfDay();
            }
            $dateRange = [$start, $end];
        }

        // $dateRange = ($start_date && $end_date)
        //     ? [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]
        //     : null;

        $footer = collect([
            'movie_key' => '-',
            'movie' => '-',
            'distributor_name' => '-',
            'branch' => '-',
            'reference' => '-',
            'theater' => '-',
            'type' => '-',
            'seats' => '-',
            'nb_seats' => '-',
            'Week #' => '-',
            'movie_show_date' => '-',
            'movie_show_time' => '-',
            'booking_date' => '-',
            'booking_time' => '-',
            'unit_price' => 0,
            'total_price' => 0,
            'imtiyaz_discount' => 0,
            'customer_name' => '-',
            'cashier' => '-',
            'booked_via' => '-',
            'payment_method' => '-',
            'tax_amount' => 0,
            'dist_perc' => 0,
            'cost_of_sale' => 0,
            'unit_cost' => 0,
        ]);

        $results = DB::table('order_seats')
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
            ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
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
                'distributors.label as distributor_label',
                'order_seats.imtiyaz_phone',
                DB::raw('COUNT(order_seats.id) as seats_count'),
                DB::raw("GROUP_CONCAT(seat) as seats"),
                DB::raw("SUM(CASE WHEN order_seats.imtiyaz_phone IS NOT NULL THEN 1 ELSE 0 END) as imtiyaz_seat_count"),
                DB::raw("CONCAT(order_seats.zone_id,'_',orders.reference) as computed_identifier"),
                'order_seats.label as type',
                'movies.name as movie',
                'movies.commission_settings as commission_settings',
                'movies.movie_key as movie_key',
                'zones.label as zone_label',
                'order_seats.date',
                'times.label as time',
                'theaters.label as theater',
                'order_seats.created_at',
                'order_seats.dist_share_percentage as dist_perc',
                'order_seats.refunded_at',
                'order_seats.week',
                'systems.label as system',
            ])
            ->when($dateRange, fn($q) => $q->whereBetween('order_seats.date', $dateRange))
            ->when($branch_id, fn($q) => $q->where('orders.branch_id', $branch_id))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->orderBy('order_seats.id', 'ASC')
            ->groupBy('computed_identifier')
            ->get();

        $rows = $results->map(function ($row) use (&$footer) {
            $unit_price = $row->unit_price;
            $seats_count = $row->seats_count;
            $total_price = $unit_price * $seats_count;
            $tax_amount = $seats_count ? ($total_price * (5 / 100)) : 0;


            $createdAt = Carbon::parse($row->created_at);



            $dist_share_percentage = 0;

            $settings = json_decode($row->commission_settings, true);

            $week = $row->week;
            $conditions = $settings['conditions'] ?? [];
            $defaultPercentage = $settings['defaultPercentage'] ?? 0;


            $index = $week - 1;

            if (isset($conditions[$index])) {
                $dist_share_percentage = $conditions[$index];
            } else {
                $dist_share_percentage = $defaultPercentage;
            }

            $share_percentage = floatval($dist_share_percentage ?? 0);
            $cost = ($total_price - $tax_amount) * ($share_percentage / 100);

            $unit_cost = $seats_count !=0 ? $cost / $seats_count : 0;


            $data = [
                'movie_key' => $row->movie_key,
                'movie' => $row->movie,
                'distributor_name' => $row->distributor_label,
                'branch' => $row->branch ?? '',
                'reference' => $row->reference,
                'theater' => $row->theater ?? '',
                'type' => $row->type,
                'seats' => $row->seats,
                'nb_seats' => $seats_count,
                'Week #' => $row->week,
                'movie_show_date' => $row->date,
                'movie_show_time' => $row->time ?? '',
                'booking_date' => $createdAt->format('d-m-Y'),
                'booking_time' => $createdAt->format('H:i:s'),
                'unit_price' => $unit_price,
                'total_price' => $total_price,
                'imtiyaz_discount' => $row->imtiyaz_seat_count,
                'customer_name' => $row->customer_name ?? '',
                'cashier' => $row->booked_by,
                'booked_via' => $row->system ?? '',
                'payment_method' => $row->payment_method ?? '',
                'tax_amount' => $tax_amount,
                'dist_perc' => $share_percentage,
                'cost_of_sale' => $cost,
                'unit_cost' => $unit_cost,
            ];

            $footer['unit_price'] += $unit_price;
            $footer['total_price'] += $total_price;
            $footer['tax_amount'] += $tax_amount;
            $footer['cost_of_sale'] += $cost;
            $footer['unit_cost'] += $unit_cost;
            $footer['imtiyaz_discount'] += $row->imtiyaz_seat_count;


            foreach (['unit_price', 'total_price', 'tax_amount', 'cost_of_sale', 'unit_cost', 'imtiyaz_discount'] as $field) {
                $data[$field] = number_format($data[$field]);
            }

            return $data;
        })->filter()->values();


        foreach (['unit_price', 'total_price', 'tax_amount', 'cost_of_sale', 'unit_cost', 'imtiyaz_discount'] as $field) {
            $footer[$field] = number_format($footer[$field]);
        }

        $this->setFooter($footer->toArray());

        return $rows;
    }



    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
