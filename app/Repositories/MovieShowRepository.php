<?php

namespace App\Repositories;

use App\Interfaces\MovieShowRepositoryInterface;
use App\Models\Branch;
use App\Models\MovieShow;
use App\Models\Theater;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class MovieShowRepository implements MovieShowRepositoryInterface
{

    public function getMovieShows($branch_id, $movie_id, $date)
    {

        return MovieShow::query()
            ->select(
                'movie_shows.id',
                'times.label as time',
                'price_groups.label as price_group',
                'branches.label_'.app()->getLocale().' as branch',
                'movie_shows.system_id as system_id',
                'times.id as time_id',
                'price_groups.id as price_group_id',
                'branches.id as branch_id',
            )
            ->selectRaw('IF(branches.id = ' . $branch_id . ', 1, 0) as `default`')
            ->whereNull('movie_shows.deleted_at')
            ->where('movie_shows.date', $date)
            ->where('movie_shows.movie_id', $movie_id)
            ->leftJoin('theaters', 'movie_shows.theater_id', 'theaters.id')
            ->leftJoin('price_groups', 'theaters.price_group_id', 'price_groups.id')
            ->leftJoin('times', 'movie_shows.time_id', 'times.id')
            ->leftJoin('branches', 'theaters.branch_id', 'branches.id')
            ->orderBy('default', 'DESC')
            ->orderBy('branch_id', 'ASC')
            ->orderBy('time_id', 'ASC')
            ->get();
    }

    public function getMovieShowById($id)
    {


        try {
            $movie_show = MovieShow::where('id', $id)
                ->whereNull('deleted_at')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $movie_show;
    }
}
