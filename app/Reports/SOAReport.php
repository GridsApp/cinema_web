<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class SOAReport extends DefaultReport
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

        $this->addColumn("glasses_count", "3D Glass");
        $this->addColumn("glasses_amount", "3D Glass Amount");

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

        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;


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
            'dist_share_amount"' => 0,
            'cinema_share_amount"' => 0,

            'glasses_count"' => 0,
            'glasses_amount"' => 0,

            'last_week_tickets"' => 0,
            'last_week_nbo"' => 0,

            'life_to_date_tickets"' => 0,
            'life_to_date_nbo"' => 0,

            'diferred_income_tickets"' => 0,
            'diferred_income_gbo"' => 0,
            'diferred_income_nbo"' => 0,
        ];


        $baseQuery = DB::table('order_seats')

            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id') // 👈 add this line
            ->select([
                'order_seats.id',
                'order_seats.price as unit_price',

                // DB::raw('COUNT(*) as seats_count'),
                // DB::raw("GROUP_CONCAT(seat) as seats"),
                DB::raw("CONCAT(order_seats.movie_id) as computed_identifier"),


                'movies.name as movie',
                'movies.movie_key as imdb',
                'distributors.label as distributor_label',
                'order_seats.week as week',
                'order_seats.dist_share_percentage as dist_share_percentage',
                'order_seats.dist_share_amount as dist_share_amount',
                DB::raw('COUNT(order_seats.id) as tickets_sold'),
                DB::raw('SUM(order_seats.price) as total_sales'),

            ])
            ->when($dateRange, fn($q) => $q->whereBetween('order_seats.date', $dateRange))
            ->whereNull('order_seats.deleted_at')
            // ->orderBy('id', 'ASC')
            ->groupBy('computed_identifier');
        $results = $baseQuery->get();

        $rows = $results->map(function ($row) use (&$footer) {
            $totals = $this->getWeekTotals([
                'tickets_sold' => $row->tickets_sold,
                'total_sales' =>  $row->total_sales ?? 0,
            ]);
            $data = [
                'imdb' => $row->imdb,
                'distributor' => $row->distributor_label,
                'movie' => $row->movie,
                'wk' => $row->week,
                'tickets_sold' => $totals['admits'], 
                'total_sales' => $totals['income'],
                'tax_amount' => 0,
                'net_total_sales' => 0,
                'share_percentage' => $row->dist_share_percentage,
                'rank' => '-',
                'dist_share_amount' => $row->dist_share_amount,
                'cinema_share_amount"' => 0,

                'glasses_count"' => 0,
                'glasses_amount"' => 0,

                'last_week_tickets"' => 0,
                'last_week_nbo"' => 0,

                'life_to_date_tickets"' => 0,
                'life_to_date_nbo"' => 0,

                'diferred_income_tickets"' => 0,
                'diferred_income_gbo"' => 0,
                'diferred_income_nbo"' => 0,

            ];


            return $data;
        })->filter()->values();

        // $footer['nb_seats'] = number_format($footer['nb_seats']);
        // $footer['total_price'] = number_format($footer['total_price']);
        // $footer['refund_amount'] = number_format($footer['refund_amount']);

        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
