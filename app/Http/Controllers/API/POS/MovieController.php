<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\System;
use App\Models\Theater;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use APITrait;
    
    public function getBranchPosActiveMovieShows($branch_id)
    {

        $system_id = request()->input('system_id', 2);
        $theaters_ids = Theater::select('id')->whereNull('deleted_at')->where('branch_id', $branch_id)->pluck('id');
        $system_ids = System::select('id')->whereNull('deleted_at')->where('id', $system_id)->pluck('id');

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
            ->whereHas('movieShows', function ($q) use ($date, $theaters_ids, $system_ids) {
                $q->whereDate('date', $date)
                    ->whereIn('theater_id', $theaters_ids)
                    ->where(function ($query) use ($system_ids) {
                        foreach ($system_ids as $id) {
                            $query->orWhere('system_id', 'like', '%"' . $id . '"%');
                        }
                    });
            })
            ->with(['movieShows' => function ($query) use ($theaters_ids, $system_ids, $date) {
                $query->whereIn('theater_id', $theaters_ids)
                    ->where(function ($query) use ($system_ids) {
                        foreach ($system_ids as $id) {
                            $query->orWhere('system_id', 'like', '%"' . $id . '"%');
                        }
                    })
                    ->whereDate('date', $date);
            }])
            ->get();


        $customMovies = $movies->map(function ($movie) {

            return [
                'id' => $movie->id,
                'image' => get_image($movie->main_image),
                'name' => $movie->name,
                'duration' => minutes_to_human($movie->duration),
                'movieShows' => $movie->movieShows->map(function ($show) {
                    return [
                        'id' => $show->id,
                        'time' => $show->time->label,
                        'theater' => $show->theater->label,
                        'screen_type' => $show->screenType->label,
                        'nb_seats' => $show->theater->nb_seats,
                        'duration' => $show->duration,
                    ];
                }),
            ];
        });
        return $this->responseData($customMovies);
    }
}
