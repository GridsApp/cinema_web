<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\CinemaStatistic;

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
        $movies = $this->movieRepository->getBranchActiveMovies(
            $first_branch,
            now()->format('Y-m-d')
        );

        $statistics=CinemaStatistic::whereNull('deleted_at')->get();
        // dd($statistics);
        return view('website.pages.home', compact('slider', 'branches', 'movies','statistics'));
    }
}
