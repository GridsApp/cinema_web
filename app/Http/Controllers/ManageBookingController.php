<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieShow;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ManageBookingController extends Controller
{
    public function render()
    {

        $date = request()->input('date');

        if (!$date) {
            $date = now();
        } else {
            try {

                $date = now()->parse($date);
            } catch (\Throwable $th) {
                $date = now();
            }
        }

        $period = collect(CarbonPeriod::create($date, (clone $date)->addDays(15)))->map(function ($d) {
            return $d->format('d-m-Y');
        })->toArray();



        $date = $date->format('Y-m-d');

        $movie_shows = MovieShow::whereNull('deleted_at')
            ->where('date', $date)
            ->get()
            ->map(function ($movie_show) {
                $movie = $movie_show->movie;
                return [
                    'image' => $movie->main_image,
                    'name' => $movie->name,
                ];
            });


        // dd($movie_shows);

        return view('pages.manage-booking', ['date' => $date, 'period' => $period,'movie_shows'=>$movie_shows]);
    }
}
