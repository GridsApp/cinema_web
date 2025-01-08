<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use twa\cmsv2\Traits\APITrait;


class TheaterSeatsController extends Controller
{
    use APITrait;

    private CartRepositoryInterface $cartRepository;


    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function listSeats($movie_show_id)
    {
   
        try {
            $movie_show = MovieShow::where('id' , $movie_show_id)->orderBy('id', 'DESC')->firstOrFail();
        } catch (\Throwable $e) {
            return $this->response(notification()->error('Movie show not found', $e->getMessage()));
        }
        
     
        $theater = Theater::whereNull('deleted_at')->where('id', $movie_show->theater_id)->first();

        $theater_map =$theater->theater_map;

        $columns =  collect($theater_map[0])->map(function ($item) {
            return (string) ($item['column'] ?? "");
        })->toArray();

        $reserved_seats= $this->cartRepository->getReservedSeats($movie_show_id);

        
        $rows =  collect($theater_map)->map(function ($item) {
            $item = collect($item)->where('isSeat', true)->first();

            return (string) ($item['row'] ?? "");
        })->toArray();


        $zone_ids =  collect($theater_map)->flatten(1)->pluck('zone')->unique()->values();
        $zones = PriceGroupZone::select('id', 'label', 'color')
            ->whereIn('id', $zone_ids)
            ->whereNull('deleted_at')
            ->get();

        $map = collect($theater_map)->flatten(1)->map(function ($item ) use ($reserved_seats) {

            if (!$item['isSeat']) {
                return null;
            }

            return [
                "color" => $item['color'],
                "available" => !in_array($item['code'] , $reserved_seats ),
                "code" => $item['code']
            ];
        })->filter()->values()->keyBy('code');

        $result = [
            "zones" => $zones,
            "columns" => $columns,
            "rows" => $rows,
            'map' => $map
        ];

        return $this->responseData($result);
    }
}
