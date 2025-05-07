<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class DailyAdmitsByItemReport extends DefaultReport
{

    public $label = "Daily Admits By Item";


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


        $this->addColumn("extra", "Extra");
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

        $date = $this->filterResults['date'] ?? null;
        $branch_id = $this->filterResults['branch_id'] ?? null;


        $dateRange = get_range_date($date);


        $lastWeekDateRange = get_range_date(now()->parse($date)->subWeek());

 
        $last_week_booked_seats_admits = OrderItem::query()
            ->select(DB::raw('item_id as identifier'), DB::raw('COUNT(*) as count'))

            ->whereNull('deleted_at')
            ->whereBetween('created_at', $lastWeekDateRange)
            ->groupBy('identifier')
            ->pluck('count', 'identifier');


        $last_week_booked_seats_income = OrderItem::query()
            ->select(DB::raw('item_id as identifier'), DB::raw('SUM(price) as count'))

            ->whereNull('deleted_at')
            ->whereBetween('created_at', $lastWeekDateRange)
            ->groupBy('identifier')
            ->pluck('count', 'identifier');


        $all_time_booked_seats_admits = OrderItem::query()
            ->select(DB::raw('item_id as identifier'), DB::raw('COUNT(*) as count'))

            ->whereNull('deleted_at')
            ->whereDate('created_at', '<=', $dateRange['start'])
            ->groupBy('identifier')
            ->pluck('count', 'identifier');

        $all_time_booked_seats_income = OrderItem::query()
            ->select(DB::raw('item_id as identifier'), DB::raw('SUM(price) as count'))

            ->whereNull('deleted_at')
            ->whereDate('created_at', '<=', $dateRange['start'])
            ->groupBy('identifier')
            ->pluck('count', 'identifier');

        $footer = [
            'extra' => '-',
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

        $booked_items = OrderItem::query()
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->join('branch_items', 'branch_items.id', '=', 'order_items.item_id')
        
            ->select("order_items.*", 'orders.branch_id', "branch_items.item_id as identifier")
            ->whereNull('order_items.deleted_at');

        if ($dateRange) {
            $booked_items->whereBetween('order_items.created_at', $dateRange);
        }
        if ($branch_id) {
            $booked_items->where('orders.branch_id', $branch_id);
        }

        $booked_items = $booked_items->get()
            ->groupBy('identifier')
         

            ->map(function ($order_items) use ($last_week_booked_seats_admits, $last_week_booked_seats_income, $all_time_booked_seats_admits, $all_time_booked_seats_income, &$footer) {


                $first_order_item = $order_items->first();


                if (!$first_order_item) {
                    return null;
                }


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

                foreach ($order_items as $order_item) {

                    $dayName = strtolower(Carbon::parse($order_item->date)->format('l'));

                    $dayCounts[$dayName] += 1;
                    $dayIncomes[$dayName] += $order_item->price;
                }

                $data = [
                    'extra' => $first_order_item->label,
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
                    'last_week_admits' => $last_week_booked_seats_admits[$first_order_item->identifier] ?? 0,
                    'last_life_admits' => $all_time_booked_seats_admits[$first_order_item->identifier] ?? 0,


                    'current_income' => collect($dayIncomes)->values()->sum(),
                    'last_week_income' => $last_week_booked_seats_income[$first_order_item->identifier] ?? 0,
                    'last_life_income' => $all_time_booked_seats_income[$first_order_item->identifier] ?? 0,
                    'percentage' => 0,
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

                $footer['percentage'] += $data['percentage'];



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


        $total = $booked_items->sum('current_admits');

        $booked_items = $booked_items->map(function ($item) use ($total) {
            $item['percentage'] = $total != 0 ? round(($item['current_admits'] / $total) * 100, 0) : 0;
            return $item;
        });



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



        $footer['percentage'] = 100;

        $this->setFooter($footer);

        return $booked_items;
    }

    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
