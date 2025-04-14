<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\OrderSeat;
use App\Models\PriceGroupZone;
use Carbon\Carbon;

class ReportRepository implements ReportRepositoryInterface
{

    public function getRangeDate($date)
    {
        $date = Carbon::parse($date);
        $startOfWeek = $date->startOfWeek(Carbon::THURSDAY);

        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::WEDNESDAY);

        return [$startOfWeek, $endOfWeek];
    }

    public function getOrdersGroupedByTypeAndMovie($date,$branch){

       

        $date=$this->getRangeDate($date);

        $booked_seats = OrderSeat::whereNull('deleted_at')
        ->whereBetween('date',$date)
        ->get();

     return $booked_seats;
        // dd($booked_seats);


    }
   
}
