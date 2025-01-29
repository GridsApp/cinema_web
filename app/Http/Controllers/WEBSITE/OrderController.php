<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use Illuminate\Http\Request;

class OrderController extends Controller
{


   private CartRepositoryInterface $cartRepository;

   public function __construct()
   {

      $this->cartRepository = app(CartRepositoryInterface::class);
   }

    public function getTheaterSeats(Request $request)
    {
        $movie_show_id = $request->input('movie_show_id'); // Ensure this matches the form input name

        // dd($movie_show_id);

        $theater_id = $request->input('theater_id');


        // dd()

        try {
            $movie_show = MovieShow::where('id' , $movie_show_id)->orderBy('id', 'DESC')->firstOrFail();

            // dd($movie_show->movie);
  
        } catch (\Throwable $e) {
   
            // return $this->response(notification()->error('Movie show not found', $e->getMessage()));
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
        // dd($columns,$rows);

        $zone_ids =  collect($theater_map)->flatten(1)->pluck('zone')->unique()->values();
        $zones = PriceGroupZone::select('id', 'label', 'color')
            ->whereIn('id', $zone_ids)
            ->whereNull('deleted_at')
            ->get();


            // dd($zones);
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
            'movie_show'=>$movie_show,
            "zones" => $zones,
            "columns" => $columns,
            "rows" => $rows,
            'map' => $map
        ];
        // dd($result);


        return view('website.pages.checkout.seat-selection', [
            'result' => $result,
        
        ]);
    }
}
