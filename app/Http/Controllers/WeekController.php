<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function getWeekRange($date)
    {
        $week_info = get_range_date($date);


        $start_date = $week_info['start'];
        $end_date = $week_info['end'];


        $period = CarbonPeriod::create(Carbon::now()->startOfYear(), $end_date);
        $week = 0;
        foreach ($period as $p) {
            if ($p->format('l') == "Wednesday") {
                $week++;
            }
        }


        $week_info['week_nb'] = $week;


        return "<div><b>Week " . $week_info['week_nb'] . " Range:</b> " .
            $start_date->isoFormat('ddd D-MMM') . " - " .
            $end_date->isoFormat('ddd D-MMM') . "</div>";
    }
}
