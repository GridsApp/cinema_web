<?php

namespace App\Livewire\Website;

use App\Interfaces\MovieShowRepositoryInterface;
use Carbon\Carbon;
use Livewire\Component;

class MovieShow extends Component
{
    public $selectedDate;
    public $dates = [];
    public $movieShows = [];
    private  $movieShowRepository;

    public function __construct()
    {
        $this->movieShowRepository = app(MovieShowRepositoryInterface::class);
    }

    public function mount()
    {
        // Default selected date is today
        $this->selectedDate = Carbon::now()->format('Y-m-d');

        // Generate a list of dates for the user to choose from
        $this->generateDates();

        // Fetch the available movie shows for the current selected date
        $this->fetchMovieShows();
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

    public function selectDate($date)
    {
        // Update the selected date and fetch the new movie shows
        $this->selectedDate = $date;
        $this->fetchMovieShows();
    }

    public function fetchMovieShows()
    {
        $branchId = 1; // Replace with the actual branch ID or make it dynamic
        $movieId = 5;  // Replace with the actual movie ID or make it dynamic
        $date = $this->selectedDate;
    
        // Fetch movie shows directly from the repository
        $shows = $this->movieShowRepository->getMovieShows($branchId, $movieId, $date)->toArray();
    
        // Group by branch and then by price group
        $this->movieShows = collect($shows)->groupBy('branch')->map(function ($branchShows) {
            return $branchShows->groupBy('price_group');
        })->toArray();



    }
    
    
    public function render()
    {
        return view('livewire.website.movie-show');
    }
}
