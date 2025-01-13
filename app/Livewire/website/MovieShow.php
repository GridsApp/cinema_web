<?php

namespace App\Livewire\Website;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Models\Branch;
use App\Models\Movie;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class MovieShow extends Component
{
    public $selectedDate;
    public $dates = [];
    public $movieShows = [];

    public $firstBranch;
    public $otherBranches;
    public $slug; // Add this to hold the slug

    private MovieShowRepositoryInterface $movieShowRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct()
    {
        $this->movieShowRepository = app(MovieShowRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->generateDates();
        $this->fetchMovieShows();
    }

    public function generateDates()
    {
        $this->dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->addDays($i);
            $this->dates[] = [
                'day' => $date->format('D'),
                'd_name' => $date->format('j'),
                'formatted' => $date->format('Y-m-d'),
            ];
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->fetchMovieShows();
    }

    public function fetchMovieShows()
    {

        $movie = Movie::where('slug', $this->slug)->whereNull('deleted_at')->first();
        if (!$movie) {
            abort(404, 'Movie not found');
        }

        $branchPrefix = Request::segment(1);
        $branch = Branch::whereNull("deleted_at")->where('web_prefix', $branchPrefix)->first();


        $movie_id = $movie->id;
        $date = $this->selectedDate;

        $branchShows = $this->movieShowRepository->getMovieShows($branch->id, $movie->id, $date)->toArray();

        // $shows = $this->movieShowRepository->getMovieShows($branch->id, $movie_id, $date)->toArray();



        $otherBranches = Branch::whereNull('deleted_at')
            ->where('id', '!=', $branch->id)
            ->get();

      
        $otherBranchShows = [];
        foreach ($otherBranches as $otherBranch) {
            $otherBranchShows[$otherBranch->id] = $this->movieShowRepository
                ->getMovieShows($otherBranch->id, $movie->id, $date)
                ->toArray();
        }

        $allShows = [
            'currentBranchShows' => $branchShows,
            'otherBranchShows' => $otherBranchShows,
        ];
    
        return $allShows; 
    }

    public function render()
    {
        return view('livewire.website.movie-show');
    }
}
