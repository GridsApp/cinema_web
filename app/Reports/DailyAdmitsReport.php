<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class DailyAdmitsReport extends DefaultReport
{

    public $label = "Daily Admits and Income";

    

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

        $this->addColumn("movie", "Movie");
        $this->addColumn("distributor", "Distributor");
        $this->addColumn("type", "Type");
        $this->addColumn("week", "Wk");



        $week_info = get_date_range($this->filterResults['date']);
        $dates =  CarbonPeriod::create($week_info['range'][0], $week_info['range'][1]);


        foreach ($dates as $date) {
            $this->addColumn(strtolower($date->format('l')), $date->isoFormat('ddd') . " " . $date->format('d-M') . '<br> Admits');
            $this->addColumn(strtolower($date->format('l')) . '_income', $date->isoFormat('ddd') . " " . $date->format('d-M') . '<br>  Income');
        }


        $this->addColumn("current_admits", "Current <br> Admits");
        $this->addColumn("current_income", "Current <br> Income");
        $this->addColumn("last_week_admits", "Last Wk <br> Admits");
        $this->addColumn("last_week_income", "Last Wk <br> Income");
        $this->addColumn("last_life_admits", "Life to Date <br> Admits");
        $this->addColumn("last_life_income", "Life to Date <br> Income");




        $date = $this->getFilter('date');
    }



    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $date = $this->filterResults['date'] ?? null;
        $branch_id = $this->filterResults['branch_id'] ?? null;



        $dateRange = get_range_date($date);


        $lastWeekDateRange = get_range_date(now()->parse($date)->subWeek());

        $last_week_booked_seats_admits = OrderSeat::with('movie.distributor', 'zone')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.zone_id) as identifier"), DB::raw("COUNT(*) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereBetween('order_seats.date', $lastWeekDateRange);
        if ($branch_id) {
            $last_week_booked_seats_admits->where('orders.branch_id', $branch_id);
        }


        $last_week_booked_seats_admits = $last_week_booked_seats_admits->groupBy('identifier')
            ->pluck('count', 'identifier');


        $last_week_booked_seats_income = OrderSeat::with('movie.distributor', 'zone')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')

            ->select(DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.zone_id) as identifier"), DB::raw("SUM(price) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereBetween('order_seats.date', $lastWeekDateRange);
        if ($branch_id) {
            $last_week_booked_seats_income->where('orders.branch_id', $branch_id);
        }
        $last_week_booked_seats_income = $last_week_booked_seats_income->groupBy('identifier')
            ->pluck('count', 'identifier');

        $all_time_booked_seats_admits = OrderSeat::with('movie.distributor', 'zone')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')

            ->select(DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.zone_id) as identifier"), DB::raw("COUNT(*) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereDate('order_seats.date', '<=', $dateRange['start']);
        if ($branch_id) {
            $all_time_booked_seats_admits->where('orders.branch_id', $branch_id);
        }
        $all_time_booked_seats_admits = $all_time_booked_seats_admits->groupBy('identifier')
            ->pluck('count', 'identifier');


        $all_time_booked_seats_income = OrderSeat::with('movie.distributor', 'zone')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')

            ->select(DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.zone_id) as identifier"), DB::raw("SUM(price) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereDate('order_seats.date', '<=', $dateRange['start']);
        if ($branch_id) {
            $all_time_booked_seats_income->where('orders.branch_id', $branch_id);
        }
        $all_time_booked_seats_income = $all_time_booked_seats_income->groupBy('identifier')
            ->pluck('count', 'identifier');

        $footer = [
            'movie' =>  'Total',
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
            'thursday_income' => 0,
            'friday_income' => 0,
            'saturday_income' => 0,
            'sunday_income' => 0,
            'monday_income' => 0,
            'tuesday_income' => 0,
            'wednesday_income' => 0,
            'current_admits' => 0,
            'current_income' => 0,
            'last_week_admits' => 0,
            'last_week_income' => 0,
            'last_life_admits' => 0,
            'last_life_income' => 0
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
            $booked_seats->whereBetween('order_seats.date', $dateRange);
        }
        if ($branch_id) {
            $booked_seats->where('orders.branch_id', $branch_id);
        }

        $booked_seats = $booked_seats->get()
            ->groupBy('identifier')

            ->map(function ($order_seats) use ($last_week_booked_seats_admits, $last_week_booked_seats_income, $all_time_booked_seats_admits, $all_time_booked_seats_income, &$footer) {

                $first_order_seat = $order_seats->first();

                if (!$first_order_seat) {
                    return null;
                }

                $movie = $first_order_seat->movie ?? '';
                $distributor = $movie->distributor->condensed_label ?? $movie->distributor?->label ?? '-';
                $zone = $first_order_seat->zone ?? '';
                $zone = ($zone->priceGroup->label ?? '-') . ' ' . ($zone->default == 1 ? '' : $zone->condensed_label ?? '');
                $week = $first_order_seat->week ?? '-';

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
                    'movie' => $movie?->condensed_name ?? $movie?->name ?? '-',
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

                    'thursday_income' => $dayIncomes['thursday'],
                    'friday_income' => $dayIncomes['friday'],
                    'saturday_income' => $dayIncomes['saturday'],
                    'sunday_income' => $dayIncomes['sunday'],
                    'monday_income' => $dayIncomes['monday'],
                    'tuesday_income' => $dayIncomes['tuesday'],
                    'wednesday_income' => $dayIncomes['wednesday'],

                    'current_admits' => collect($dayCounts)->values()->sum(),
                    'current_income' => collect($dayIncomes)->values()->sum(),
                    'last_week_admits' => $last_week_booked_seats_admits[$first_order_seat->identifier] ?? 0,
                    'last_week_income' => $last_week_booked_seats_income[$first_order_seat->identifier] ?? 0,
                    'last_life_admits' => $all_time_booked_seats_admits[$first_order_seat->identifier] ?? 0,
                    'last_life_income' => $all_time_booked_seats_income[$first_order_seat->identifier] ?? 0
                ];

                $footer['thursday'] += $data['thursday'];
                $footer['friday'] += $data['friday'];
                $footer['saturday'] += $data['saturday'];
                $footer['sunday'] += $data['sunday'];
                $footer['monday'] += $data['monday'];
                $footer['tuesday'] += $data['tuesday'];
                $footer['wednesday'] += $data['wednesday'];
                $footer['thursday_income'] += $data['thursday_income'];
                $footer['friday_income'] += $data['friday_income'];
                $footer['saturday_income'] += $data['saturday_income'];
                $footer['sunday_income'] += $data['sunday_income'];
                $footer['monday_income'] += $data['monday_income'];
                $footer['tuesday_income'] += $data['tuesday_income'];
                $footer['wednesday_income'] += $data['wednesday_income'];

                $footer['current_admits'] += $data['current_admits'];
                $footer['current_income'] += $data['current_income'];
                $footer['last_week_admits'] += $data['last_week_admits'];
                $footer['last_week_income'] += $data['last_week_income'];
                $footer['last_life_admits'] += $data['last_life_admits'];
                $footer['last_life_income'] += $data['last_life_income'];

                $data['thursday'] = number_format($data['thursday']);
                $data['friday'] = number_format($data['friday']);
                $data['saturday'] = number_format($data['saturday']);
                $data['sunday'] = number_format($data['sunday']);
                $data['monday'] = number_format($data['monday']);
                $data['tuesday'] = number_format($data['tuesday']);
                $data['wednesday'] = number_format($data['wednesday']);

                $data['thursday_income'] = number_format($data['thursday_income']);
                $data['friday_income'] = number_format($data['friday_income']);
                $data['saturday_income'] = number_format($data['saturday_income']);
                $data['sunday_income'] = number_format($data['sunday_income']);
                $data['monday_income'] = number_format($data['monday_income']);
                $data['tuesday_income'] = number_format($data['tuesday_income']);
                $data['wednesday_income'] = number_format($data['wednesday_income']);

                $data['current_admits'] = number_format($data['current_admits']);
                $data['current_income'] = number_format($data['current_income']);
                $data['last_week_admits'] = number_format($data['last_week_admits']);
                $data['last_week_income'] = number_format($data['last_week_income']);
                $data['last_life_admits'] = number_format($data['last_life_admits']);
                $data['last_life_income'] = number_format($data['last_life_income']);


                return $data;
            })->filter()->values();


        $footer['thursday'] = number_format($footer['thursday']);
        $footer['friday'] = number_format($footer['friday']);
        $footer['saturday'] = number_format($footer['saturday']);
        $footer['sunday'] = number_format($footer['sunday']);
        $footer['monday'] = number_format($footer['monday']);
        $footer['tuesday'] = number_format($footer['tuesday']);
        $footer['wednesday'] = number_format($footer['wednesday']);

        $footer['thursday_income'] = number_format($footer['thursday_income']);
        $footer['friday_income'] = number_format($footer['friday_income']);
        $footer['saturday_income'] = number_format($footer['saturday_income']);
        $footer['sunday_income'] = number_format($footer['sunday_income']);
        $footer['monday_income'] = number_format($footer['monday_income']);
        $footer['tuesday_income'] = number_format($footer['tuesday_income']);
        $footer['wednesday_income'] = number_format($footer['wednesday_income']);

        $footer['current_admits'] = number_format($footer['current_admits']);
        $footer['current_income'] = number_format($footer['current_income']);
        $footer['last_week_admits'] = number_format($footer['last_week_admits']);
        $footer['last_week_income'] = number_format($footer['last_week_income']);
        $footer['last_life_admits'] = number_format($footer['last_life_admits']);
        $footer['last_life_income'] = number_format($footer['last_life_income']);

        $this->setFooter($footer);

        return $booked_seats;
    }

    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
