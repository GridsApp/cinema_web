<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use twa\cmsv2\Traits\APITrait;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\MovieShow;
use App\Models\System;
use App\Models\Theater;


class MovieController extends Controller
{
    use APITrait;

    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }


    public function show($id)
    {
        $user = request()->user;

     
        $movie = $this->movieRepository->getMovie($id, $user);

        if (!$movie) {
            return $this->response(notification('get-movie')->error());
        }

        return $this->responseData($movie);
    }

    public function search()
    {


        $search = request()->input('search');

        if (!$search) {
            return $this->responseData([]);
        }

        $results = $this->movieRepository->searchMovies($search);

        return $this->responseData($results);
    }

   
}
