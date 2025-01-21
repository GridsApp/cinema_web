<?php

namespace App\Livewire\Website;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Models\Branch;
use App\Models\Movie;
use App\Models\ReservedSeat;
use App\Models\Theater;
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
    public $slug;
    public $branchPrefix;  // Store branchPrefix in component state

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
        $this->branchPrefix = Request::segment(1);  // Store branchPrefix in state
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

        $branch = Branch::whereNull('deleted_at')->where('web_prefix', $this->branchPrefix)->first();
        if (!$branch) {
            abort(404, 'Branch not found');
        }

        $movie_id = $movie->id;
        $date = $this->selectedDate;

        // Fetch shows
        $shows = $this->movieShowRepository->getMovieShows($branch->id, $movie_id, $date)->toArray();

        if (empty($shows)) {
            $this->movieShows = [];
            $this->firstBranch = $branch->label;
            $this->otherBranches = [];
            $this->movieShows['message'] = 'No movie shows available';
            return;
        }

        foreach ($shows as &$show) {
            $theater = Theater::where('id', $show['theater_id'])->whereNull('deleted_at')->first();
            $reservedSeatsCount = ReservedSeat::where('movie_show_id', $show['id'])->count();
            // dd($reservedSeatsCount);
            $show['theater'] = $theater; // Attach theater data
            $show['available_seats'] = $theater->nb_seats - $reservedSeatsCount;
            // dd(            $show['available_seats']);
        }

        // Group the modified $shows array
        $this->movieShows = collect($shows)
            ->groupBy('branch')
            ->map(function ($branchShows) {
                return $branchShows->groupBy('price_group');
            })
            ->toArray();

        $this->firstBranch = $branch->label;

        if (isset($this->movieShows[$this->firstBranch]) && count($this->movieShows[$this->firstBranch]) > 0) {
            $this->otherBranches = collect($this->movieShows)->except($this->firstBranch)->toArray();
        } else {
            $this->firstBranch = $branch->label;
            $this->otherBranches = $this->movieShows;
        }
    }



    public function render()
    {
        return view('livewire.website.movie-show');
    }
}
