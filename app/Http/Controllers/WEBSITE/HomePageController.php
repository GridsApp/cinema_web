<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\AboutBanner;
use App\Models\Branch;
use App\Models\CinemaStatistic;
use App\Models\HomeParagraphBanner;
use App\Models\Slideshow;
use Illuminate\Support\Facades\Request;

class HomePageController extends Controller
{
    private MovieRepositoryInterface $movieRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
    }
    public function home(Request $request)
    {


     
        $slider = Slideshow::whereNull('deleted_at')->get();


        $paragraph_banner=HomeParagraphBanner::whereNull('deleted_at')->first();
        $banner=AboutBanner::whereNull('deleted_at')->where('position','home')->orderBy('id', 'DESC')->first();
        $branches = $this->branchRepository->getBranches();
      
        $cinemaPrefix = request()->segment(1);

        $branch = Branch::whereNull('deleted_at')->where('web_prefix', $cinemaPrefix)->first();

   
        if (!$branch) {
            abort(404, 'Branch not found');
        }

       
        $branch_id = Branch::whereNull('deleted_at')->where('web_prefix', $cinemaPrefix)->pluck('id');
    
    
        $movies = $this->movieRepository->getBranchActiveMovies(
            $branch_id,
            now()->format('Y-m-d')
        );
    

        // dd($movies);
        // $movie_id = $movie->id;

        $statistics=CinemaStatistic::whereNull('deleted_at')->get();
      
        $languagePrefix = request()->segment(2);
        // dd($statistics);
        return view('website.pages.home', compact('slider','paragraph_banner','branch', 'branches', 'movies','statistics',  'cinemaPrefix',
        'languagePrefix','banner'));
    }
}
