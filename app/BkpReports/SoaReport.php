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


   

    public function getRangeDate($date)
    {

        $date = Carbon::parse($date);
        $startOfWeek = $date->startOfWeek(Carbon::THURSDAY);

        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::WEDNESDAY);

        return [$startOfWeek, $endOfWeek];
    }

    // public function rows()
    // {
    //     if (!$this->filterResults) {
    //         return [];
    //     }
    
    //     $date = $this->filterResults['date'] ?? null;
    //     $branch_id = $this->filterResults['branch_id'] ?? null;
    
    //     $dateRange = $this->getRangeDate($date);
    //     $lastWeekDateRange = $this->getRangeDate(now()->parse($date)->subWeek());
    
    //     $last_week_booked_seats_admits = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("COUNT(*) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereBetween('date', $lastWeekDateRange)
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $last_week_booked_seats_income = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("SUM(price) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereBetween('date', $lastWeekDateRange)
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $all_time_booked_seats_admits = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("COUNT(*) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereDate('date', '<=', $dateRange[1])
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $all_time_booked_seats_income = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("SUM(price) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereDate('date', '<=', $dateRange[1])
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $deferred_income_admits = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("COUNT(*) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereDate('date', '>', $dateRange[1])
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $deferred_income_gbo = OrderSeat::select(DB::raw("movie_id as identifier"), DB::raw("SUM(price) as count"))
    //         ->whereNull('deleted_at')
    //         ->whereNull('refunded_at')
    //         ->whereDate('date', '>', $dateRange[1])
    //         ->groupBy('identifier')
    //         ->pluck('count', 'identifier');
    
    //     $footer = [
    //         'imdb' => 'Total',
    //         'distributor' => '-',
    //         'movie' => '-',
    //         'wk' => '-',
    //         'tickets_sold' => 0,
    //         'total_sales' => 0,
    //         'tax_amount' => 0,
    //         'net_total_sales' => 0,
    //         'share_percentage' => '-',
    //         'rank' => '-',
    //         'dist_share_amount' => 0,
    //         'cinema_share_amount' => 0,
    //         'last_week_tickets' => 0,
    //         'last_week_nbo' => 0,
    //         'life_to_date_tickets' => 0,
    //         'life_to_date_nbo' => 0,
    //         'diferred_income_tickets' => 0,
    //         'diferred_income_gbo' => 0,
    //         'diferred_income_nbo' => 0,
    //     ];
    
    //     $results = DB::table('order_seats')
    //         ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')
    //         ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
    //         ->select([
    //             'order_seats.movie_id as computed_identifier',
    //             'movies.name as movie',
    //             'movies.movie_key as imdb',
    //             'distributors.label as distributor_label',
    //             'order_seats.week as week',
    //             'order_seats.dist_share_percentage as dist_share_percentage',
    //             'order_seats.dist_share_amount as dist_share_amount',
    //             DB::raw('COUNT(order_seats.id) as tickets_sold'),
    //             DB::raw('SUM(order_seats.price) as total_sales'),
    //         ])
    //         ->whereBetween('order_seats.date', $dateRange)
    //         ->whereNull('order_seats.deleted_at')
    //         ->whereNull('order_seats.refunded_at')
    //         ->groupBy('order_seats.movie_id', 'movies.name', 'movies.movie_key', 'distributors.label', 'order_seats.week', 'order_seats.dist_share_percentage', 'order_seats.dist_share_amount')
    //         ->get();
    
    //     $booked_seats = $results->map(function ($row) use (&$footer, $last_week_booked_seats_admits, $last_week_booked_seats_income, $all_time_booked_seats_admits, $all_time_booked_seats_income, $deferred_income_admits, $deferred_income_gbo) {
    //         $identifier = $row->computed_identifier;
    
    //         $totals = $this->getWeekTotals([
    //             'tickets_sold' => $row->tickets_sold,
    //             'total_sales' => $row->total_sales ?? 0,
    //         ]);
    
    //         $tax = $this->taxCalculation($totals['income']);
    //         $net_total = $totals['income'] - $tax;
    //         $cinema_share = $net_total - ($row->dist_share_percentage * $net_total / 100);
    
    //         $data = [
    //             'imdb' => $row->imdb,
    //             'distributor' => $row->distributor_label,
    //             'movie' => $row->movie,
    //             'wk' => $row->week,
    //             'tickets_sold' => $totals['admits'],
    //             'total_sales' => $totals['income'],
    //             'tax_amount' => $tax,
    //             'net_total_sales' => $net_total,
    //             'share_percentage' => $row->dist_share_percentage,
    //             'rank' => '-',
    //             'dist_share_amount' => $row->dist_share_amount,
    //             'cinema_share_amount' => $cinema_share,
    //             'last_week_tickets' => $last_week_booked_seats_admits[$identifier] ?? 0,
    //             'last_week_nbo' => $last_week_booked_seats_income[$identifier] ?? 0,
    //             'life_to_date_tickets' => $all_time_booked_seats_admits[$identifier] ?? 0,
    //             'life_to_date_nbo' => $all_time_booked_seats_income[$identifier] ?? 0,
    //             'diferred_income_tickets' => $deferred_income_admits[$identifier] ?? 0,
    //             'diferred_income_gbo' => $deferred_income_gbo[$identifier] ?? 0,
    //             'diferred_income_nbo' => ($deferred_income_gbo[$identifier] ?? 0) - $this->taxCalculation($deferred_income_gbo[$identifier] ?? 0),
    //         ];
    
           
    //         $footer['tickets_sold'] += $data['tickets_sold'];
    //         $footer['total_sales'] += $data['total_sales'];
    //         $footer['tax_amount'] += $data['tax_amount'];
    //         $footer['net_total_sales'] += $data['net_total_sales'];
    //         $footer['dist_share_amount'] += $data['dist_share_amount'];
    //         $footer['cinema_share_amount'] += $data['cinema_share_amount'];
    //         $footer['last_week_tickets'] += $data['last_week_tickets'];
    //         $footer['last_week_nbo'] += $data['last_week_nbo'];
    //         $footer['life_to_date_tickets'] += $data['life_to_date_tickets'];
    //         $footer['life_to_date_nbo'] += $data['life_to_date_nbo'];
    //         $footer['diferred_income_tickets'] += $data['diferred_income_tickets'];
    //         $footer['diferred_income_gbo'] += $data['diferred_income_gbo'];
    //         $footer['diferred_income_nbo'] += $data['diferred_income_nbo'];
    
    //         return array_map(fn($v) => is_numeric($v) ? number_format($v) : $v, $data);
    //     });
    
    //     $rows = $booked_seats->sortByDesc(fn($r) => str_replace(',', '', $r['net_total_sales']))->values()->map(function ($item, $index) {
    //         $item['rank'] = $index + 1;
    //         return $item;
    //     });
    
      
    //     foreach ($footer as $key => $value) {
    //         if (is_numeric($value)) {
    //             $footer[$key] = number_format($value);
    //         }
    //     }
    
    //     $this->setFooter($footer);
    
    //     return $rows;
    // }



    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }
    
        $date = $this->filterResults['date'] ?? null;
        $branch_id = $this->filterResults['branch_id'] ?? null;
    
        $dateRange = $this->getRangeDate($date);
        $lastWeekDateRange = $this->getRangeDate(now()->parse($date)->subWeek());

        $aggregates = function ($range, $operator = 'between') {
            $query = OrderSeat::select(
                DB::raw("movie_id as identifier"),
                DB::raw("COUNT(*) as admits"),
                DB::raw("SUM(price) as gbo")
            )->whereNull('deleted_at')
             ->whereNull('refunded_at');
    
            if ($operator === 'between') {
                $query->whereBetween('date', $range);
            } elseif ($operator === '<=') {
                $query->whereDate('date', '<=', $range[1]);
            } else {
                $query->whereDate('date', '>', $range[1]);
            }
    
            return $query->groupBy('identifier')->get()->keyBy('identifier');
        };
    
        $lastWeek = $aggregates($lastWeekDateRange);
        $lifeToDate = $aggregates($dateRange, '<=');
        $deferred = $aggregates($dateRange, '>');
    
       
        $results = DB::table('order_seats')
            ->join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
            ->select(
                'order_seats.movie_id as identifier',
                'movies.name as movie',
                'movies.movie_key as imdb',
                'distributors.label as distributor',
                'order_seats.week',
                'order_seats.dist_share_percentage',
                DB::raw('SUM(order_seats.dist_share_amount) as dist_share_amount'),
                DB::raw('COUNT(order_seats.id) as tickets_sold'),
                DB::raw('SUM(order_seats.price) as total_sales')
            )
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
                'distributor' => $row->distributor,
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
    
         
            foreach ([
                'tickets_sold', 'total_sales', 'tax_amount', 'net_total_sales',
                'dist_share_amount', 'cinema_share_amount',
                'last_week_tickets', 'last_week_nbo',
                'life_to_date_tickets', 'life_to_date_nbo',
                'diferred_income_tickets', 'diferred_income_gbo', 'diferred_income_nbo'
            ] as $field) {
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
