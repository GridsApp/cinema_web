<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterSeatsController extends Controller
{
    public function listSeats()
    {


        $movie_show = MovieShow::orderBy('id', 'DESC')->first();
        $theater = Theater::whereNull('deleted_at')->where('id', $movie_show->theater_id)->first();
        $theater_map = json_decode($theater->theater_map, true);

        $columns =  collect($theater_map[0])->map(function ($item) {
            return (string) ($item['column'] ?? "");
        })->toArray();



        $rows =  collect($theater_map)->map(function ($item) {
            $item = collect($item)->where('isSeat', true)->first();

            return (string) ($item['row'] ?? "");
        })->toArray();


        $zone_ids =  collect($theater_map)->flatten(1)->pluck('zone')->unique()->values();
        $zones = PriceGroupZone::select('id', 'label', 'color')
            ->whereIn('id', $zone_ids)
            ->whereNull('deleted_at')
            ->get();

        $map = collect($theater_map)->flatten(1)->map(function ($item) {

            if (!$item['isSeat']) {
                return null;
            }

            return [
                "color" => $item['color'],
                "available" => true,
                "code" => $item['code']
            ];
        })->filter()->values()->keyBy('code');

        $result = [
            "zones" => $zones,
            "columns" => $columns,
            "rows" => $rows,
            'map' => $map
        ];


        return $result;
        return response()->json([
            'rows' => $rows,
            'nbColumns' => $nbColumns,
            'zones' => $zones,

        ]);
    }
}
