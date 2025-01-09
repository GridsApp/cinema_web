<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Branch;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieRepositoryInterface $movieRepository;
  

    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
     
    }
    public function listing()
    {


        // $services = ServicesModel::where('cancelled', 0)->orderBy('orders')->get();
        // $categories = CategoriesModel::where('cancelled', 0)->orderBy('orders')->get();
        $movies = Movie::whereNull('deleted_at')->get();
        $branches = Branch::whereNull('deleted_at')->get();

        return view('website.pages.movie.listing', [
            'movies' => $movies,
            'branches' => $branches,

        ]);
    }


    public function details($slug) {
        // dd("here");
        $movie_id = Movie::where('slug', $slug)->whereNull('deleted_at')->pluck('id');
        if (!$movie_id) {
            abort(404, 'Movie not found');
        }
        $movie_details = $this->movieRepository->getMovie($movie_id);

     
       

        return view('website.pages.movie.details', [
            
            'movie_details' => $movie_details,
        ]);
    }
}
