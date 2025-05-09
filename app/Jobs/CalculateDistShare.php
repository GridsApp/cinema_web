<?php

namespace App\Jobs;

use App\Models\OrderSeat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateDistShare implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order_seats= OrderSeat::select(
            'order_seats.id',
            'order_seats.week',
            'order_seats.price',
            'order_seats.dist_share_percentage',
            'order_seats.dist_share_amount',
            'movies.commission_settings'
        )->where(function($q){
            $q->orWhereNull('order_seats.dist_share_percentage');
            $q->orWhereNull('order_seats.dist_share_amount');
        })
        ->where('order_id' , $this->order_id)
        ->join('movies', 'order_seats.movie_id','movies.id')
        ->get();

        foreach($order_seats as $order_seat){

            $settings = json_decode($order_seat->commission_settings, true);

            $week = $order_seat->week;
            $conditions = $settings['conditions'] ?? [];
            $defaultPercentage = $settings['defaultPercentage'] ?? 0;


            $index = $week - 1;

            if (isset($conditions[$index])) {
                $dist_share_percentage = $conditions[$index];
            } else {
                $dist_share_percentage = $defaultPercentage;
            }

            $order_seat->dist_share_percentage = $dist_share_percentage;
            $order_seat->dist_share_amount = calculate_share_amount($order_seat->price,$dist_share_percentage,5);
            $order_seat->save();
        }
    }
}
