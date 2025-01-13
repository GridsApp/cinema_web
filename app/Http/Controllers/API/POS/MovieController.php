<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\System;
use App\Models\Theater;
use twa\cmsv2\Traits\APITrait;


class MovieController extends Controller
{
    use APITrait;

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


        $movies = Movie::select('id', 'name', 'release_date', 'main_image', 'duration', 'genre_id')
            ->whereNull('deleted_at')
            ->whereHas('movieShows', function ($q) use ($date, $theaters_ids) {
                $q->whereDate('date', $date)
                    ->whereIn('theater_id', $theaters_ids);
            })
            ->with(['movieShows' => function ($query) use ($theaters_ids, $date) {
                $query->whereIn('theater_id', $theaters_ids)
                    // ->where(function ($query) use ($system_ids) {
                    //     foreach ($system_ids as $id) {
                    //         $query->orWhere('system_id', 'like', '%"' . $id . '"%');
                    //     }
                    // })
                    ->whereDate('date', $date);
            }])
            ->get();


        $customMovies = $movies->map(function ($movie) {

            $total_seats = 0;
            $total_available_seats = 0;
            $total_reserved_seats = 0;

            $movieShows = $movie->movieShows->map(function ($show) use (
                &$total_seats,
                &$total_available_seats,
                &$total_reserved_seats
            ) {

                $reserved_seats = 10;

                $theater = $show->theater;

                $nb_seats = $show->theater->nb_seats;

                $total_seats += $nb_seats;
                $total_available_seats += $nb_seats - $reserved_seats;
                $total_reserved_seats += $reserved_seats;

                return [
                    'id' => $show->id,
                    'time' => $show->time->label,
                    'theater' => [
                        'id' => $theater->id,
                        'label' => $theater->label
                    ],
                    'screen_type' => $show->screenType->label,
                    'seats' => [
                        'total' => $nb_seats,
                        'reserved' => $reserved_seats,
                        'available' => $nb_seats - $reserved_seats,
                        'percentage' => round($reserved_seats / $nb_seats, 2)
                    ],
                    'duration' => $show->duration,
                    'price' => currency_format(10000)
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
                    'percentage' => round($total_reserved_seats / $total_seats, 2)
                ],
                'movieShows' => $movieShows
            ];
        });
        return $this->responseData($customMovies, notification()->success('Movies Fetched', 'Movies fetched successfully.'));
    }
}
