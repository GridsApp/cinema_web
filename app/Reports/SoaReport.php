<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class SoaReport extends DefaultReport
{

    public $label = "SOA";



    public function filters()
    {
        $this->addFilter('filter_date');
        $this->addFilter('filter_branch');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("imdb", "IMDB");
        $this->addColumn("distributor", "Distributor");
        $this->addColumn("movie", "Movie");
        $this->addColumn("wk", "WK");
        $this->addColumn("tickets_sold", "Tickets Sold");
        $this->addColumn("total_sales", "Gross Box Office");
        $this->addColumn("tax_amount", "TAX 5% Amount");
        $this->addColumn("net_total_sales", "Net Box Office");
        $this->addColumn("share_percentage", "Share %");
        $this->addColumn("rank", "Movie Rank");
        $this->addColumn("dist_share_amount", "Distributor Share Amount");
        $this->addColumn("cinema_share_amount", "Cinema Share");



        $this->addColumn("last_week_tickets", "Last Week Tickets");
        $this->addColumn("last_week_nbo", "Last Week NBO");

        $this->addColumn("life_to_date_tickets", "Life to Date Tickets");
        $this->addColumn("life_to_date_nbo", "Life to Date NBO");

        $this->addColumn("diferred_income_tickets", "Deferred Income Tickets");
        $this->addColumn("diferred_income_gbo", "Deferred Income GBO");
        $this->addColumn("diferred_income_nbo", "Deferred Income NBO");
    }

    public function getWeekTotals($data)
    {

        $admits = $data['tickets_sold'];


        $income = $data['total_sales'] ?? 0;
        return [
            'admits' => $admits,
            'income' => $income,
        ];
    }





    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }

        $date = $this->filterResults['date'] ?? null;
        $branch_id = $this->filterResults['branch_id'] ?? null;

        $dateRange = get_range_date($date);
        $lastWeekDateRange = get_range_date(now()->parse($date)->subWeek());

        // dd($dateRange);
        $aggregates = function ($dateRange, $operator = 'between',$branch_id) {
            $query = OrderSeat::select(
                DB::raw("movie_id as identifier"),
                DB::raw("COUNT(*) as admits"),
                DB::raw("SUM(price) as gbo")
            )->join('orders', 'orders.id', '=', 'order_seats.order_id')
                ->whereNull('order_seats.deleted_at')
                ->whereNull('order_seats.refunded_at');
            if ($branch_id) {

                // dd("here");
                $query->where('orders.branch_id', $branch_id);
            }
            if ($operator === 'between') {
                $query->whereBetween('date', $dateRange);
            } elseif ($operator === '<=') {
                $query->whereDate('date', '<=', $dateRange['end']);
            } else {
                $query->whereDate('date', '>', $dateRange['end']);
            }

            return $query->groupBy('identifier')->get()->keyBy('identifier');
        };

        $lastWeek = $aggregates($lastWeekDateRange, 'between', $branch_id);
        $lifeToDate = $aggregates($dateRange, '<=', $branch_id);
        $deferred = $aggregates($dateRange, '>', $branch_id);


        $results = DB::table('order_seats')
        ->join('orders', 'orders.id', '=', 'order_seats.order_id') 

            ->join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
            ->select(
                'order_seats.movie_id as identifier',
                'movies.name as movie',
                'movies.movie_key as imdb',
                'distributors.label as distributor',
                'distributors.condensed_label as distributor_condensed',
                'order_seats.week',
                'order_seats.dist_share_percentage',
                DB::raw('SUM(order_seats.dist_share_amount) as dist_share_amount'),
                DB::raw('COUNT(order_seats.id) as tickets_sold'),
                DB::raw('SUM(order_seats.price) as total_sales')
            )
            ->when($branch_id, fn($q) => $q->where('orders.branch_id', $branch_id)) 

            ->whereBetween('order_seats.date', $dateRange)
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->groupBy('order_seats.movie_id', 'movies.name', 'movies.movie_key', 'distributors.label', 'order_seats.week', 'order_seats.dist_share_percentage')
            ->get();

        $footer = [
            'imdb' => 'Total',
            'distributor' => '-',
            'movie' => '-',
            'wk' => '-',
            'tickets_sold' => 0,
            'total_sales' => 0,
            'tax_amount' => 0,
            'net_total_sales' => 0,
            'share_percentage' => '-',
            'rank' => '-',
            'dist_share_amount' => 0,
            'cinema_share_amount' => 0,
            'last_week_tickets' => 0,
            'last_week_nbo' => 0,
            'life_to_date_tickets' => 0,
            'life_to_date_nbo' => 0,
            'diferred_income_tickets' => 0,
            'diferred_income_gbo' => 0,
            'diferred_income_nbo' => 0,
        ];

        $booked_seats = $results->map(function ($row) use (&$footer, $lastWeek, $lifeToDate, $deferred) {
            $id = $row->identifier;

            $tax = taxCalculation($row->total_sales);
            $net_total = $row->total_sales - $tax;
            $cinema_share = $net_total - ($row->dist_share_percentage * $net_total / 100);

            $data = [
                'imdb' => $row->imdb,
                'distributor' => !empty($row->distributor_condensed) ? $row->distributor_condensed : $row->distributor,
                'movie' => $row->movie,
                'wk' => $row->week,
                'tickets_sold' => $row->tickets_sold,
                'total_sales' => $row->total_sales,
                'tax_amount' => $tax,
                'net_total_sales' => $net_total,
                'share_percentage' => $row->dist_share_percentage,
                'rank' => '-',
                'dist_share_amount' => $row->dist_share_amount,
                'cinema_share_amount' => $cinema_share,
                'last_week_tickets' => $lastWeek[$id]->admits ?? 0,
                'last_week_nbo' => $lastWeek[$id]->gbo ?? 0,
                'life_to_date_tickets' => $lifeToDate[$id]->admits ?? 0,
                'life_to_date_nbo' => $lifeToDate[$id]->gbo ?? 0,
                'diferred_income_tickets' => $deferred[$id]->admits ?? 0,
                'diferred_income_gbo' => $deferred[$id]->gbo ?? 0,
                'diferred_income_nbo' => ($deferred[$id]->gbo ?? 0) - taxCalculation($deferred[$id]->gbo ?? 0),
            ];


            foreach (
                [
                    'tickets_sold',
                    'total_sales',
                    'tax_amount',
                    'net_total_sales',
                    'dist_share_amount',
                    'cinema_share_amount',
                    'last_week_tickets',
                    'last_week_nbo',
                    'life_to_date_tickets',
                    'life_to_date_nbo',
                    'diferred_income_tickets',
                    'diferred_income_gbo',
                    'diferred_income_nbo'
                ] as $field
            ) {
                $footer[$field] += $data[$field];
            }

            return array_map(fn($v) => is_numeric($v) ? number_format($v) : $v, $data);
        });

        $rows = $booked_seats->sortByDesc(fn($r) => str_replace(',', '', $r['net_total_sales']))->values()->map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        });

        foreach ($footer as $key => $value) {
            if (is_numeric($value)) {
                $footer[$key] = number_format($value);
            }
        }

        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
