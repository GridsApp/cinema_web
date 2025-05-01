<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\PriceGroupZoneRepositoryInterface;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\System;
use App\Models\Theater;
use App\Models\Time;
use Carbon\Carbon;
use twa\cmsv2\Traits\APITrait;


class MovieController extends Controller
{
    use APITrait;


    //cartRepository

    private CartRepositoryInterface $cartRepository;
    private PriceGroupZoneRepositoryInterface $priceGroupZoneRepository;


    public function __construct(
        CartRepositoryInterface $cartRepository,
        PriceGroupZoneRepositoryInterface $priceGroupZoneRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->priceGroupZoneRepository = $priceGroupZoneRepository;
    }

    public function getBranchPosActiveMovieShows($branch_id)
    {

        $theaters_ids = Theater::select('id')->whereNull('deleted_at')->where('branch_id', $branch_id)->pluck('id');

        $date = request()->input('date');
        if ($date) {
            try {
                $date = now()->parse($date);
            } catch (\Throwable $th) {
                return $this->response(notification()->error('could not parse date', 'The date must be dd-mm-yyyy format'));
            }
        } else {
            $date = now();
        }


        // $movies = Movie::select('id', 'name', 'release_date', 'main_image', 'duration', 'genre_id')
        //     ->whereNull('deleted_at')
        //     ->whereHas('movieShows', function ($q) use ($date, $theaters_ids) {
        //         $q->whereDate('date', $date)
        //             ->whereIn('theater_id', $theaters_ids);
        //     })
        //     ->with(['movieShows' => function ($query) use ($theaters_ids, $date) {
        //         $query->whereIn('theater_id', $theaters_ids)
        //             ->whereDate('date', $date);
        //     }])

        //     ->get();


   

        $current_time = (string) now()->setTimezone(env('TIMEZONE', 'Asia/Baghdad'))->subMinutes(35)->format('H:i');

        $strict = true;
        $strict=$strict && now()->setTimezone(env('TIMEZONE', 'Asia/Baghdad'))->format('Y-m-d') >= now()->parse($date)->format('Y-m-d');

        $round_time = round_time($current_time);

        
        $times = [];
        if($strict){
            $times = Time::whereNull('deleted_at')->where('iso' , '>=' , $round_time)->pluck('id')->toArray();
        }

        $movies = Movie::select('id', 'name', 'release_date', 'main_image', 'duration', 'genre_id' , 'orders')
            ->whereNull('deleted_at')
            ->whereHas('movieShows', function ($q) use ($date, $theaters_ids , $times , $strict) {
                $q->whereNull('deleted_at');
                $q->whereDate('date', $date)
                    ->whereIn('theater_id', $theaters_ids);

                    if($strict){
                        // if(abs(now()->diffInDays($date)) < 1){
                            $q->whereIn('time_id' , $times);
                        // }
                    }

            })

            ->with(['movieShows' => function ($query) use ($theaters_ids, $date, $times , $strict) {
                $query->whereNull('deleted_at');
                $query->whereIn('theater_id', $theaters_ids)
                    ->whereDate('date', $date)
                    ->orderBy('time_id', 'asc');

                    if($strict){
                        $query->whereIn('time_id' , $times);     
                    }

                    // if(abs(now()->diffInDays($date)) < 1){
                    //     $query->whereIn('time_id' , $times);
                    // }

            }])
           
            // ->orderBy('orders' , 'ASC')
            ->get()

            // ->sortBy(function ($movie) {
            //     return $movie->orders + (optional($movie->movieShows->first())->time_id/100);
            // })
            ->values();




        $customMovies = $movies->map(function ($movie) {

            $total_seats = 0;
            $total_available_seats = 0;
            $total_reserved_seats = 0;

            $movieShows = $movie->movieShows->map(function ($show) use (
                &$total_seats,
                &$total_available_seats,
                &$total_reserved_seats
            ) {


                // TO BE OPTIMIZED

                $reserved_seats = count($this->cartRepository->getReservedSeats($show->id));

                $theater = $show->theater;

                $nb_seats = $show->theater->nb_seats;

                $total_seats += $nb_seats;
                $total_available_seats += $nb_seats - $reserved_seats;
                $total_reserved_seats += $reserved_seats;

              
                $priceGroup = $show->theater->priceGroup;

                $default_zone = PriceGroupZone::where('default' , 1)->where('price_group_id' , $priceGroup->id)->first();

                try {
                    $price = $this->priceGroupZoneRepository->getPriceByZonePerDate($default_zone , $show->date , $show->time->iso ?? '');
                } catch (\Throwable $th) {
                    $price = 12000;      
                }

                return [
                    'id' => $show->id,
                    'time_id' => $show->time_id,
                    'time' => $show->time->label ?? '',
                    'theater' => [
                        'id' => $theater->id,
                        'label' => $theater->label
                    ],
                    'screen_type' => $show->screenType->label ?? '',
                    'price_group' => $priceGroup->label ?? '',
                    'seats' => [
                        'total' => $nb_seats,
                        'reserved' => $reserved_seats,
                        'available' => $nb_seats - $reserved_seats,
                        'percentage' => round($reserved_seats / $nb_seats, 2)
                    ],
                    'duration' => $show->duration,
                    'price' => currency_format($price)
                ];
            });

            return [
                'id' => $movie->id,
                'image' => get_image($movie->main_image),
                'name' => $movie->name,
                'duration' => minutes_to_human($movie->duration),
                'seats' => [
                    'total' => $total_seats,
                    'reserved' => $total_reserved_seats,
                    'available' => $total_available_seats,
                    'percentage' => $total_seats == 0 ? 0 : round($total_reserved_seats / $total_seats, 2)
                ],
                'movieShows' => $movieShows,
                'orders' => $movie->orders + (($movieShows[0]["time_id"] ?? 0) / 100)
            ];
        })->sortBy('orders')->values();
        return $this->responseData($customMovies);
    }
}
