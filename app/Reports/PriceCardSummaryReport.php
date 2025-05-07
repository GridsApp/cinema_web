<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class PriceCardSummaryReport extends DefaultReport
{

    public $label = "Price Card Summary";



    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_payment_method');
        $this->addFilter('filter_distributor');
        $this->addFilter('filter_movie');


    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }
       $this->addColumn("type" , "Type");
       $this->addColumn("tickets" , "# Tickets");
       $this->addColumn("sales_amount" , "Total Amount");
       $this->addColumn("refund_tickets" , "# Refund Tickets");
       $this->addColumn("refund_perc" , "% Refund Tickets");
       $this->addColumn("refund_amount" , "Refunded Tickets");
       $this->addColumn("net_tickets" , "Net # Tickets");
       $this->addColumn("net_amount" , "Net Total Amount");
    }


    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $start_date = $this->filterResults['start_date'] ?? null;
        $end_date = $this->filterResults['end_date'] ?? null;
        $branch = $this->filterResults['branch_id'] ?? null;
        $payment_method = $this->filterResults['payment_method_id'] ?? null;
        $distributor = $this->filterResults['distributor_id'] ?? null;
        $movie = $this->filterResults['movie_id'] ?? null;

        $dateRange = ($start_date && $end_date)
    ? [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]
    : null;


        $footer = [

            'type' => 'Total',
            'tickets' => 0,
            'sales_amount' => 0,
            'refund_tickets' => 0,
            'refund_perc' => 0,
            'refund_amount' => 0,
            'net_tickets' => 0,
            'net_amount' => 0,
            
        ];


        $baseQuery = DB::table('order_seats')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
         
            ->leftJoin('price_group_zones as zones', 'order_seats.zone_id', '=', 'zones.id')
            ->leftJoin('screen_types', 'order_seats.screen_type_id', '=', 'screen_types.id')
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id') 

            ->select([
                'orders.id as order_id',
                // 'orders.reference',
                'order_seats.id',
                'zones.label as zone_label',
                'screen_types.label as screen_type_label',
                'order_seats.price as unit_price',

                DB::raw('COUNT(*) as tickets'),
                DB::raw("SUM(CASE WHEN order_seats.refunded_at IS NOT NULL THEN 1 ELSE 0 END) as refund_tickets"),

              
                DB::raw("CONCAT(order_seats.zone_id, '_', order_seats.screen_type_id) as computed_identifier")
,

            ])
            ->when($dateRange, fn($q) => $q->whereBetween('order_seats.date', $dateRange))
            ->when($branch, fn($q) => $q->where('orders.branch_id', $branch))
            ->when($payment_method, fn($q) => $q->where('orders.payment_method_id', $payment_method))
            ->when($distributor, fn($q) => $q->where('movies.distributor_id', $distributor))
            ->when($movie, fn($q) => $q->where('order_seats.movie_id', $movie))
            ->whereNull('order_seats.deleted_at')
            ->orderBy('id', 'ASC')
            ->groupBy('computed_identifier');


     
        $results = $baseQuery->get();
        $rows = $results->map(function ($row) use (&$footer) {

           
            $tickets = $row->tickets;
            $refund_tickets = $row->refund_tickets ?? 0;
            $unit_price = $row->unit_price;
         
            $total_price = $unit_price * $tickets;
            $refund_amount = $unit_price * $refund_tickets;
            $net_tickets = $tickets - $refund_tickets;
            $net_amount = $total_price - $refund_amount;
        
            $refund_perc = $tickets > 0 ? round(($refund_tickets / $tickets) * 100, 2) : 0;
        
  
            $data = [
                'type' => $row->zone_label . ' - ' . $row->screen_type_label,
                'tickets' => $tickets,
                'sales_amount' => $total_price,
                'refund_tickets' => $refund_tickets,
                'refund_perc' => $refund_perc,
                'refund_amount' => $refund_amount,
                'net_tickets' => $net_tickets,
                'net_amount' => $net_amount,
            ];


            $footer['tickets'] += $data['tickets'];
            $footer['sales_amount'] += $data['sales_amount'];
            $footer['refund_tickets'] += $data['refund_tickets'];
            $footer['refund_amount'] += $data['refund_amount'];
            $footer['net_tickets'] += $data['net_tickets'];
            $footer['net_amount'] += $data['net_amount'];

            $data['tickets'] = number_format($data['tickets']);
            $data['sales_amount'] = number_format($data['sales_amount']);
            $data['refund_tickets'] = number_format($data['refund_tickets']);
            $data['refund_amount'] = number_format($data['refund_amount']);
            $data['net_tickets'] = number_format($data['net_tickets']);
            $data['net_amount'] = number_format($data['net_amount']);

            return $data;
        })->filter()->values();

        $footer['tickets'] = number_format($footer['tickets']);
        $footer['sales_amount'] = number_format($footer['sales_amount']);
        $footer['refund_tickets'] = number_format($footer['refund_tickets']);
        $footer['refund_amount'] = number_format($footer['refund_amount']);
        $footer['net_tickets'] = number_format($footer['net_tickets']);
        $footer['net_amount'] = number_format($footer['net_amount']);

        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
