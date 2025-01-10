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
        // Use the slug to get the movie ID
        $movie = Movie::where('slug', $this->slug)->whereNull('deleted_at')->first();
        if (!$movie) {
            abort(404, 'Movie not found');
        }
        
        $movie_id = $movie->id;
        $date = $this->selectedDate;
        $shows = $this->movieShowRepository->getShows($movie_id, $date)->toArray();

        if (empty($shows)) {
            $this->movieShows = [];
            $this->firstBranch = null;
            $this->otherBranches = [];
        } else {
            $this->movieShows = collect($shows)->groupBy('branch')->map(function ($branchShows) {
                return $branchShows->groupBy('price_group');
            })->toArray();

            $branches = array_keys($this->movieShows);
            $this->firstBranch = $branches[0];
            $this->otherBranches = array_slice($branches, 1);
        }
    }

    public function render()
    {
        return view('livewire.website.movie-show');
    }
}
