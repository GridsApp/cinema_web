<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class WeekController extends Controller
{


    private OrderRepositoryInterface $orderRepository;



    public function __construct(
        OrderRepositoryInterface $orderRepository

    ) {
        $this->orderRepository = $orderRepository;
    }

    public function getWeekRange($date)
    {
        $week_info = get_range_date($date);



        $start_date = $week_info['start'];
        $end_date = $week_info['end'];

        // dd($week_info);
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

    public function test()
    {



        // $playerID = "f5cce57a-e00c-4ba6-99ab-568a356be797";
        $playerID = "8748ebc5-9bd3-4b05-9baa-d293f479df22";

        $conditions = [
            "condition" => [],
            "value" => []
        ];


        $titles = [
            'en' => 'hi',
            'ar' => 'hi'
        ];
        $messages = [
            'en' => 'hello',
            'ar' => 'hello'
        ];

        $data = [];

        $config = config('omnipush.onesignal');
        (new \twa\cmsv2\Http\Controllers\OneSignalController($config['data']))->sendPush($titles,$messages,$conditions , $data , null , $playerID);


        return;


        $order = Order::find(916754);



        // dd(now());

        $this->orderRepository->sendSurveyNotification($order, '2025-08-08 11:24:00', 0);


   
    }
}
