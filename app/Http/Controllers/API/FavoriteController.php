<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use twa\cmsv2\Traits\APITrait;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\MovieFavorite;

class FavoriteController extends Controller
{

    use APITrait;

    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function list() {

        $user = request()->user;

        $ids =  MovieFavorite::where('user_id', $user->id)->pluck('movie_id')->unique()->values()->toArray();

       
        $movies = $this->movieRepository->getMovies($ids);

      
        return $this->responseData($movies);
    }

    public function toggle($movie_id)
    {

        $user = request()->user;
        $movie = $this->movieRepository->getMovie($movie_id);

        if (!$movie) {
            return $this->response(notification()->error('Movie not found', "Movie not found"));
        }

        $favorite = MovieFavorite::where('user_id', $user->id)->where('movie_id', $movie_id)->first();

        if ($favorite) {
            $favorite->delete();
            return $this->response(notification()->success('Movie removed from favorites', "Movie removed from favorites"));
        } else {

           $favorite = new MovieFavorite;
           $favorite->user_id = $user->id;
           $favorite->movie_id = $movie_id;
           $favorite->save();

        return $this->response(notification()->success('Movie added to favorites', "Movie added to favorites"));

        }

    }
}
