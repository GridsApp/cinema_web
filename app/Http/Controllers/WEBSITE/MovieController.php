<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Models\Branch;
use App\Models\Movie;
use App\Repositories\MovieShowRepository;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class MovieController extends Controller
{
    private MovieRepositoryInterface $movieRepository;
    private BranchRepositoryInterface $branchRepository;
    private MovieShowRepositoryInterface $movieShowRepository;


    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
        $this->movieShowRepository = app(MovieShowRepositoryInterface::class);
    }
    public function listing()
    {
        // $movies = Movie::whereNull('deleted_at')->get();
        // $branches = Branch::whereNull('deleted_at')->get();

        return view('website.pages.movie.listing', [
            // 'movies' => $movies,
            // 'branches' => $branches,

        ]);
    }



    public function details($cinema_prefix, $language_prefix, $slug)
    {


        $movie_id = Movie::where('slug', $slug)->whereNull('deleted_at')->pluck('id');
        if (!$movie_id) {
            abort(404, 'Movie not found');
        }

        $movie_details = $this->movieRepository->getMovie($movie_id);
        $date = now()->parse(now()->format('Y-m-d'));

        return view('website.pages.movie.details', [
            'slug' => $slug,
            'movie_details' => $movie_details,
            'cinema_prefix' => $cinema_prefix,
            'language_prefix' => $language_prefix,
        ]);
    }
}
