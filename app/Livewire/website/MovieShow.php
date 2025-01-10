<?php

namespace App\Livewire\Website;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Models\Movie;
use Carbon\Carbon;
use Livewire\Component;

class MovieShow extends Component
{
    public $selectedDate;
    public $dates = [];
    public $movieShows = [];
    public $currentMovieSlug;
    public $firstBranch;


    private MovieShowRepositoryInterface $movieShowRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct()
    {
        $this->movieShowRepository = app(MovieShowRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
    }

    public function mount()
    {
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->generateDates();

        $defaultMovie = Movie::whereNull('deleted_at')->first();
        if ($defaultMovie) {
            $this->currentMovieSlug = $defaultMovie->slug; // Save the slug
            $this->fetchMovieShows($defaultMovie->slug);
        }
    }

    public function generateDates()
    {
        $this->dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->addDays($i);
            $this->dates[] = [
                'day' => $date->format('l'),
                'd_name' => $date->format('F j, Y'),
                'formatted' => $date->format('Y-m-d'),
            ];
        }
    }

    public function selectDate($date, $slug)
    {
        $this->selectedDate = $date;
        $this->fetchMovieShows($slug);
    }

    public function fetchMovieShows($slug)
    {
        $movie_id = Movie::where('slug', $slug)->whereNull('deleted_at')->pluck('id');
        if (!$movie_id) {
            abort(404, 'Movie not found');
        }
    
        $date = $this->selectedDate;
        $branches = $this->branchRepository->getBranches(); // Assuming this is an array or collection
    
        $first_branch = $branches->first();
        $first_branch_shows = $this->movieShowRepository->getMovieShows($first_branch['id'], $movie_id, $date)->toArray();
    
        // Initialize an array to hold shows for all branches, starting with the first branch
        $all_shows = [
            $first_branch['id'] => $first_branch_shows
        ];
    
        // Fetch shows for the other branches
        foreach ($branches->skip(1) as $branch) {
            dd($branch['id']);
            // Get the shows for each branch and add them to the $all_shows array
            $branch_shows = $this->movieShowRepository->getMovieShows($branch['id'], $movie_id, $date)->toArray();
      
            $all_shows[$branch['id']] = $branch_shows;

            
        }
    
        // Group the shows by branch and price group
        $this->movieShows = collect($all_shows)->mapWithKeys(function ($shows, $branchId) use ($branches) {
            $branchName = collect($branches)->where('id', $branchId)->first()['label'];  // Assuming branches is an array
            return [
                $branchName => collect($shows)->groupBy('price_group')
            ];
        })->toArray();
        dd($this->movieShows);
    }
    

    public function render()
    {
        return view('livewire.website.movie-show');
    }
}
