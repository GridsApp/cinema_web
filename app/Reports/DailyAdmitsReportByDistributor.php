<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class DailyAdmitsReportByDistributor extends DefaultReport
{

    public $label = "Daily Admits By Distributor";


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


        $this->addColumn("distributor", "Distributor");
        $this->addColumn("percentage", "Perc. %");

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
        
        $date = $this->filterResults['date'];
        $branch_id = $this->filterResults['branch_id'] ?? null;
        $dateRange = get_range_date($date);
        $lastWeekDateRange = get_range_date(now()->parse($date)->subWeek());
        
        // Fetch last week booked seats income grouped by distributor_id
        $last_week_booked_seats_income = OrderSeat::join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(DB::raw("movies.distributor_id as identifier"), DB::raw("SUM(order_seats.price) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereBetween('order_seats.date', $lastWeekDateRange);
        
        if ($branch_id) {
            $last_week_booked_seats_income->where('orders.branch_id', $branch_id);
        }
        
        $last_week_booked_seats_income = $last_week_booked_seats_income
            ->groupBy('movies.distributor_id')
            ->pluck('count', 'identifier');
        
        // Fetch last week booked seats admits grouped by distributor_id
        $last_week_booked_seats_admits = OrderSeat::join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(DB::raw("movies.distributor_id as identifier"), DB::raw("COUNT(order_seats.id) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereBetween('order_seats.date', $lastWeekDateRange);
        
        if ($branch_id) {
            $last_week_booked_seats_admits->where('orders.branch_id', $branch_id);
        }
        
        $last_week_booked_seats_admits = $last_week_booked_seats_admits
            ->groupBy('movies.distributor_id')
            ->pluck('count', 'identifier');
        
        // Fetch all-time booked seats admits grouped by distributor_id
        $all_time_booked_seats_admits = OrderSeat::join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(DB::raw("movies.distributor_id as identifier"), DB::raw("COUNT(*) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereDate('order_seats.date', '<=', $dateRange['end']);
        
        if ($branch_id) {
            $all_time_booked_seats_admits->where('orders.branch_id', $branch_id);
        }
        
        $all_time_booked_seats_admits = $all_time_booked_seats_admits
            ->groupBy('movies.distributor_id')
            ->pluck('count', 'identifier');
        
        // Fetch all-time booked seats income grouped by distributor_id
        $all_time_booked_seats_income = OrderSeat::join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select(DB::raw("movies.distributor_id as identifier"), DB::raw("SUM(order_seats.price) as count"))
            ->whereNull('order_seats.deleted_at')
            ->whereNull('order_seats.refunded_at')
            ->whereDate('order_seats.date', '<=', $dateRange['end']);
        
        if ($branch_id) {
            $all_time_booked_seats_income->where('orders.branch_id', $branch_id);
        }
        
        $all_time_booked_seats_income = $all_time_booked_seats_income
            ->groupBy('movies.distributor_id')
            ->pluck('count', 'identifier');
        
        // Initialize footer aggregates
        $footer = [
            'distributor' => '-',
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
            'last_life_income' => 0,
            'percentage' => 0,
        ];
        
        // Fetch booked seats for current filter
        $booked_seats = OrderSeat::join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->select("order_seats.*", 'orders.branch_id', DB::raw("movies.distributor_id as identifier"))
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
            ->map(function ($order_seats) use (
                $last_week_booked_seats_admits,
                $last_week_booked_seats_income,
                $all_time_booked_seats_admits,
                $all_time_booked_seats_income,
                &$footer
            ) {
                $first_order_seat = $order_seats->first();
                if (!$first_order_seat) {
                    return null;
                }
        
                $movie = $first_order_seat->movie ?? null;
                $distributor = $movie?->distributor->condensed_label ?? $movie?->distributor?->label ?? '-';
        
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
                    if (isset($dayCounts[$dayName])) {
                        $dayCounts[$dayName] += 1;
                        $dayIncomes[$dayName] += $order_seat->price;
                    }
                }
        
                $data = [
                    'distributor' => $distributor,
                    'percentage' => 0,
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
        
                    'current_admits' => array_sum($dayCounts),
                    'current_income' => array_sum($dayIncomes),
        
                    'last_week_admits' => $last_week_booked_seats_admits[$first_order_seat->identifier] ?? 0,
                    'last_week_income' => $last_week_booked_seats_income[$first_order_seat->identifier] ?? 0,
                    'last_life_admits' => $all_time_booked_seats_admits[$first_order_seat->identifier] ?? 0,
                    'last_life_income' => $all_time_booked_seats_income[$first_order_seat->identifier] ?? 0,
                ];
        
                // Accumulate footer totals as raw numbers
                foreach (['thursday', 'friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday'] as $day) {
                    $footer[$day] += $data[$day];
                    $footer[$day . '_income'] += $data[$day . '_income'];
                }
        
                $footer['current_admits'] += $data['current_admits'];
                $footer['current_income'] += $data['current_income'];
                $footer['last_week_admits'] += $data['last_week_admits'];
                $footer['last_week_income'] += $data['last_week_income'];
                $footer['last_life_admits'] += $data['last_life_admits'];
                $footer['last_life_income'] += $data['last_life_income'];
        
                // Calculate percentage if last_life_admits > 0
                if ($data['last_life_admits'] > 0) {
                    $data['percentage'] = number_format(($data['current_admits'] / $data['last_life_admits']) * 100, 2);
                } else {
                    $data['percentage'] = number_format(0, 2);
                }
        
                // Format numbers for display
                foreach (['thursday', 'friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday'] as $day) {
                    $data[$day] = number_format($data[$day]);
                    $data[$day . '_income'] = number_format($data[$day . '_income']);
                }
        
                $data['current_admits'] = number_format($data['current_admits']);
                $data['current_income'] = number_format($data['current_income']);
                $data['last_week_admits'] = number_format($data['last_week_admits']);
                $data['last_week_income'] = number_format($data['last_week_income']);
                $data['last_life_admits'] = number_format($data['last_life_admits']);
                $data['last_life_income'] = number_format($data['last_life_income']);
        
                return $data;
            })
            ->filter() // Remove null entries if any
            ->values();
        
        // Format footer numbers after accumulation
        foreach (['thursday', 'friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday'] as $day) {
            $footer[$day] = number_format($footer[$day]);
            $footer[$day . '_income'] = number_format($footer[$day . '_income']);
        }
        
        $footer['current_admits'] = number_format($footer['current_admits']);
        $footer['current_income'] = number_format($footer['current_income']);
        $footer['last_week_admits'] = number_format($footer['last_week_admits']);
        $footer['last_week_income'] = number_format($footer['last_week_income']);
        $footer['last_life_admits'] = number_format($footer['last_life_admits']);
        $footer['last_life_income'] = number_format($footer['last_life_income']);
        $footer['percentage'] = number_format($footer['current_admits'] > 0 && $footer['last_life_admits'] > 0
            ? ($footer['current_admits'] / $footer['last_life_admits']) * 100
            : 0, 2);
        
        return [
            'rows' => $booked_seats,
            'footer' => $footer,
        ];
        






        // return [

        //     [

        //         'movie' => 'Hovig',
        //         'distributer' => '',
        //         'type' => '',
        //         'week' => '',
        //         'thursday' => '',
        //         'friday' => '',
        //         'saturday' => '',
        //         'sunday' => '',
        //         'monday' => '',
        //         'tuesday' => '',
        //         'wednesday' => '',
        //         'current' => '',
        //         'last_week' => '',
        //         'last_life' => ''
        //     ],
        //     [

        //         'movie' => 'Nourhane',
        //         'distributer' => '',
        //         'type' => '',
        //         'week' => '',
        //         'thursday' => '',
        //         'friday' => '',
        //         'saturday' => '',
        //         'sunday' => '',
        //         'monday' => '',
        //         'tuesday' => '',
        //         'wednesday' => '',
        //         'current' => '',
        //         'last_week' => '',
        //         'last_life' => ''
        //     ]


        // ];
    }

    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
