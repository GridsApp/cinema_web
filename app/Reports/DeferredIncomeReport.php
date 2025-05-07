<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class DeferredIncomeReport extends DefaultReport
{

    public $label = "Deferred Income";


    public function filters()
    {
        $this->addFilter('filter_date');
        $this->addFilter('filter_branch');
    }


    public function header()
    {


        if (!$this->filterResults) {

            return [];
        }

        $this->addColumn("movie", "Movie");
        $this->addColumn("distributor", "Distributor");
        $this->addColumn("type", "Type");
        $this->addColumn("week", "Wk");


        $week_info = get_date_range($this->filterResults['date']);
        $dates =  CarbonPeriod::create($week_info['range'][0], $week_info['range'][1]);


        foreach ($dates as $date) {
            $this->addColumn(strtolower($date->format('l')), $date->isoFormat('ddd') . " " . $date->format('d-M') . '<br> Tickets ');
            $this->addColumn(strtolower($date->format('l')) . '_nbo', $date->isoFormat('ddd') . " " . $date->format('d-M') . '<br> NBO');
        }

        $this->addColumn("current_week_sales" , "Current Wk");
        $this->addColumn("current_week_sales_nbo" , "Current Wk NBO");


        $date = $this->getFilter('date');
    }

    public function getRangeDate($date)
    {

        $date = Carbon::parse($date);
        $startOfWeek = $date->startOfWeek(Carbon::THURSDAY);

        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::WEDNESDAY);

        return [$startOfWeek, $endOfWeek];
    }


    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }


        $date = $this->filterResults['date'] ?? null;
        $branch_id = $this->filterResults['branch_id'] ?? null;


        $dateRange = get_range_date($date);



        $footer = [
            'movie' =>  '-',
            'distributor' => '-',
            'type' => '-',
            'week' => '-',
            'thursday' => 0,
            'friday' => 0,
            'saturday' => 0,
            'sunday' => 0,
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday_nbo' => 0,
            'friday_nbo' => 0,
            'saturday_nbo' => 0,
            'sunday_nbo' => 0,
            'monday_nbo' => 0,
            'tuesday_nbo' => 0,
            'wednesday_nbo' => 0,
            'current_week_sales'=>0,
            'current_week_sales_nbo'=>0,
           
        ];

        $booked_seats = OrderSeat::with('movie.distributor', 'zone')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(
                'order_seats.*',
                'orders.branch_id',
                DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.zone_id) as identifier")
            )
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at');


        if ($dateRange) {
          
            $booked_seats->where('order_seats.date', '>', $dateRange);
            
        }
        if ($branch_id) {
            $booked_seats->where('orders.branch_id', $branch_id);
        }

        $booked_seats = $booked_seats->get()
            ->groupBy('identifier')

            ->map(function ($order_seats) use (&$footer) {

                $first_order_seat = $order_seats->first();

                if (!$first_order_seat) {
                    return null;
                }


                $movie = $first_order_seat->movie ?? '';
                $distributor = $movie->distributor->condensed_label ?? '';
                $zone = $first_order_seat->zone ?? '';
                $zone = ($zone->priceGroup->label ?? '') . ' ' . ($zone->default == 1 ? '' : $zone->condensed_label ?? '');
                $week = $first_order_seat->week ?? '';

                $dayCounts = [
                    'thursday' => 0,
                    'friday' => 0,
                    'saturday' => 0,
                    'sunday' => 0,
                    'monday' => 0,
                    'tuesday' => 0,
                    'wednesday' => 0,

                ];

                $dayIncomes = [
                    'thursday' => 0,
                    'friday' => 0,
                    'saturday' => 0,
                    'sunday' => 0,
                    'monday' => 0,
                    'tuesday' => 0,
                    'wednesday' => 0,
                ];

                foreach ($order_seats as $order_seat) {

                    $dayName = strtolower(Carbon::parse($order_seat->date)->format('l'));
                    $dayCounts[$dayName] += 1;
                    $dayIncomes[$dayName] += $order_seat->price;
                }




                $data = [
                    'movie' => $movie?->name ?? '',
                    'distributor' => $distributor,
                    'type' => $zone,
                    'week' => $week,
                    'thursday' => $dayCounts['thursday'],
                    'friday' => $dayCounts['friday'],
                    'saturday' => $dayCounts['saturday'],
                    'sunday' => $dayCounts['sunday'],
                    'monday' => $dayCounts['monday'],
                    'tuesday' => $dayCounts['tuesday'],
                    'wednesday' => $dayCounts['wednesday'],

                    'thursday_nbo' => $dayIncomes['thursday'],
                    'friday_nbo' => $dayIncomes['friday'],
                    'saturday_nbo' => $dayIncomes['saturday'],
                    'sunday_nbo' => $dayIncomes['sunday'],
                    'monday_nbo' => $dayIncomes['monday'],
                    'tuesday_nbo' => $dayIncomes['tuesday'],
                    'wednesday_nbo' => $dayIncomes['wednesday'],

                    'current_week_sales' => collect($dayCounts)->values()->sum(),
                    'current_week_sales_nbo' => collect($dayIncomes)->values()->sum(),
                ];

                $footer['thursday'] += $data['thursday'];
                $footer['friday'] += $data['friday'];
                $footer['saturday'] += $data['saturday'];
                $footer['sunday'] += $data['sunday'];
                $footer['monday'] += $data['monday'];
                $footer['tuesday'] += $data['tuesday'];
                $footer['wednesday'] += $data['wednesday'];
                $footer['thursday_nbo'] += $data['thursday_nbo'];
                $footer['friday_nbo'] += $data['friday_nbo'];
                $footer['saturday_nbo'] += $data['saturday_nbo'];
                $footer['sunday_nbo'] += $data['sunday_nbo'];
                $footer['monday_nbo'] += $data['monday_nbo'];
                $footer['tuesday_nbo'] += $data['tuesday_nbo'];
                $footer['wednesday_nbo'] += $data['wednesday_nbo'];
                $footer['current_week_sales'] += $data['current_week_sales'];
                $footer['current_week_sales_nbo'] += $data['current_week_sales_nbo'];

             
                $data['thursday'] = number_format($data['thursday']);
                $data['friday'] = number_format($data['friday']);
                $data['saturday'] = number_format($data['saturday']);
                $data['sunday'] = number_format($data['sunday']);
                $data['monday'] = number_format($data['monday']);
                $data['tuesday'] = number_format($data['tuesday']);
                $data['wednesday'] = number_format($data['wednesday']);

                $data['thursday_nbo'] = number_format($data['thursday_nbo']);
                $data['friday_nbo'] = number_format($data['friday_nbo']);
                $data['saturday_nbo'] = number_format($data['saturday_nbo']);
                $data['sunday_nbo'] = number_format($data['sunday_nbo']);
                $data['monday_nbo'] = number_format($data['monday_nbo']);
                $data['tuesday_nbo'] = number_format($data['tuesday_nbo']);
                $data['wednesday_nbo'] = number_format($data['wednesday_nbo']);
                $data['current_week_sales'] = number_format($data['current_week_sales']);
                $data['current_week_sales_nbo'] = number_format($data['current_week_sales_nbo']);
             
                return $data;
            })->filter()->values();


        $footer['thursday'] = number_format($footer['thursday']);
        $footer['friday'] = number_format($footer['friday']);
        $footer['saturday'] = number_format($footer['saturday']);
        $footer['sunday'] = number_format($footer['sunday']);
        $footer['monday'] = number_format($footer['monday']);
        $footer['tuesday'] = number_format($footer['tuesday']);
        $footer['wednesday'] = number_format($footer['wednesday']);

        $footer['thursday_nbo'] = number_format($footer['thursday_nbo']);
        $footer['friday_nbo'] = number_format($footer['friday_nbo']);
        $footer['saturday_nbo'] = number_format($footer['saturday_nbo']);
        $footer['sunday_nbo'] = number_format($footer['sunday_nbo']);
        $footer['monday_nbo'] = number_format($footer['monday_nbo']);
        $footer['tuesday_nbo'] = number_format($footer['tuesday_nbo']);
        $footer['wednesday_nbo'] = number_format($footer['wednesday_nbo']);
        $footer['current_week_sales'] = number_format($footer['current_week_sales']);
        $footer['current_week_sales_nbo'] = number_format($footer['current_week_sales_nbo']);
     
        $this->setFooter($footer);

        return $booked_seats;
    }

    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
