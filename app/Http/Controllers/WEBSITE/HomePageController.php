<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Branch;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\Slideshow;


class HomePageController extends Controller
{
    private MovieRepositoryInterface $movieRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
    }
    public function home()
    {
        $slider = Slideshow::whereNull('deleted_at')->get();
        $branches = $this->branchRepository->getBranches();
        $first_branch = $branches->first();
        // dd($branches);
        $branches = $this->branchRepository->getBranches();
        // $this->movieRepository->getMovies

        // $movies = Movie::whereNull('deleted_at')->get();

        $movies = $this->movieRepository->getBranchActiveMovies(
            $first_branch,
            now()->format('Y-m-d')
        );




        // $genre_ids_array = $movies->pluck('genre_id')->flatten()->unique();


        // $genre_labels = MovieGenre::whereIn('id', $genre_ids_array)->pluck('label', 'id');

        return view('website.pages.home', compact('slider', 'branches', 'movies'));
    }
}
