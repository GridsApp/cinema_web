<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use twa\cmsv2\Traits\APITrait;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;

class BranchController extends Controller
{

    use APITrait;

    private MovieRepositoryInterface $movieRepository;
    private MovieShowRepositoryInterface $movieShowRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct(
        MovieRepositoryInterface $movieRepository,
        MovieShowRepositoryInterface $movieShowRepository,
        BranchRepositoryInterface $branchRepository

    ) {
        $this->movieRepository = $movieRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->branchRepository = $branchRepository;
    }


    public function list()
    {

        $display = null;

        if (request()->has('display')) {
            $search = (string) request()->input('display');
            $display = in_array($search, ["0", "false", "null"])  ? 0 : 1;
        }

        $branches = $this->branchRepository->getBranches($display);

        return $this->responseData($branches);
        // return $this->responseData($branches, notification()->success('Branches Fetched', 'Branches fetched successfully.'));

    }

    public function activeMovies($branch_id)
    {

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
        $movies = $this->movieRepository->getBranchActiveMovies($branch_id, $date);
        $categories = [
            ['key' => 'now-showing', 'label' => 'Now Showing'],
            ['key' => 'new-movies', 'label' => 'New Movies'],
            ['key' => 'coming-soon', 'label' => 'Coming Soon']
        ];
        $categories = collect($categories)->map(function ($category) use ($movies) {
            $category['movies'] =  (clone $movies)->filter(function ($item) use ($category) {
                return in_array($category['key'], $item['categories']);
            })->map(function ($movie) {
                unset($movie['categories']);
                return $movie;
            })->values();
            return $category;
        });

        return $this->responseData($categories);
    }

    public function moviesShows($branch_id, $movie_id)
    {


        $date = request()->input('date');
        $system = request()->input('system', 1);

        if ($date) {
            try {
                $date = now()->parse($date);
            } catch (\Throwable $th) {
                return $this->response(notification()->error('could not parse date', 'The date must be dd-mm-yyyy format'));
            }
        } else {
            $date = now();
        }

        $movie_shows = $this->movieShowRepository->getMovieShows($branch_id, $movie_id, $date);

        $result = [];

        // dd($movie_shows);
        foreach ($movie_shows->groupBy('branch') as $branch => $branch_shows) {

            if (count($branch_shows) == 0) {
                continue;
            }

            $result_by_group = [];
            foreach ($branch_shows->groupBy('price_group') as $price_group => $price_group_shows) {

                if (count($price_group_shows) == 0) {
                    continue;
                }


                $result_by_group[] = [
                    "id" => $price_group_shows[0]['price_group_id'],
                    "label" => $price_group,
                    "movie_shows" => $price_group_shows->map(function ($show) use ($system) {

                        // dd($show->system_id);

                        // $disabled = $show->visibility !=

                        $disabled = !(is_array($show->system_id) && in_array($system, $show->system_id));

                        return [
                            'id' => $show->id,
                            'time' => $show->time,
                            'disabled' => false,
                            // 'disabled' => $disabled, // Work on it tomorrow
                            'percentage' => 0
                        ];
                    })
                ];
            }

            $result[] = [
                'id' => $branch_shows[0]["branch_id"],
                "label" => $branch,
                "default" => $branch_shows[0]["branch_id"] == $branch_id,
                "price_groups" => $result_by_group
            ];
        }
        return $this->responseData($result);
    }
}
