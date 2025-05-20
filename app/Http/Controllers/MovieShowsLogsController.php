<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\MovieShowCreationLog;
use App\Models\Theater;
use App\Rules\TimeConflictRule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieShowsLogsController extends Controller
{

    public function render()
    {
        return view('pages.movie-show-logs');
    }



    public function getDateOfFirstMovieShowInBranch($movie_id, $branch_id)
    {


        $theaters_ids = Theater::where('branch_id', $branch_id)
            ->whereNull('deleted_at')
            ->pluck('id');

        $firstShow = MovieShow::where('movie_id', $movie_id)->whereIn('theater_id', $theaters_ids)
            ->orderBy('date', 'ASC')
            ->orderBy('time_id', 'ASC')
            ->first();

        return $firstShow->date ?? null;
    }

    public function calculateWeekNumber($current_date, $first_show_date = null)
    {

        if (!$first_show_date) {
            return 1;
        }
        $period = CarbonPeriod::create($first_show_date, $current_date)->count();
        return intdiv($period - 1, 7) + 1;
    }
    public function test()
    {
        $log = MovieShowCreationLog::find(9);

       
        $movie = Movie::find($log->movie_id);
        $theater = Theater::find($log->theater_id);
        
        if (!$movie || !$theater) {
            $log->status = 'error';
            $log->message = 'Invalid movie or theater';
            $log->save();
            return;
        }

       
        $slots = ceil($movie->duration / 15);


        if (!validate_movie_show(
            $log->theater_id,
            $log->date,
            $log->time_id,
            $slots,
            [] 
        )) {
            $log->status = 'error';
            $log->message = "Time Conflict";
            $log->save();
            return;
        }


        $first_show_date = $this->getDateOfFirstMovieShowInBranch($log->movie_id, $theater->branch_id);


        $week = $this->calculateWeekNumber(new \DateTime($log->date), $first_show_date ?? new \DateTime($log->date));
     
        try {

            $movie_show = new MovieShow();
            $movie_show->screen_type_id = $log->screen_type_id;
            $movie_show->theater_id = $log->theater_id;
            $movie_show->movie_id = $log->movie_id;
            $movie_show->time_id = $log->time_id;
            $movie_show->end_time_id = $log->time_id + $slots - 1;
            $movie_show->duration = $movie->duration;
            $movie_show->date = $log->date;
            $movie_show->visibility = 0;
            $movie_show->group = uniqid();
            $movie_show->color = $log->color;
            $movie_show->week = $week;
            $movie_show->save();

            $log->status = 'success';
            $log->save();
        } catch (\Exception $e) {
            $log->status = 'error';
            $log->message = $e->getMessage();
            $log->save();
        }
    }
}
