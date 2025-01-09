<?php

namespace App\Livewire\Website;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Branch;
use Livewire\Component;

class MovieListing extends Component
{
    public $selectedBranch;
    public $searchTerm;
    public $movies = [];

    private MovieRepositoryInterface $movieRepository;

    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
    }

    public function mount()
    {
        $this->selectedBranch = null;
        $this->searchTerm = '';
        $this->movies = [];
    }

    public function getMoviesForBranch()
    {
        $this->movies = $this->movieRepository->getBranchActiveMovies(
            $this->selectedBranch,
            now()->format('Y-m-d')
        );
    }

    public function filterMovies()
    {

        if ($this->selectedBranch) {

            $this->movies = $this->movieRepository->getBranchActiveMovies(
                $this->selectedBranch,
                now()->format('Y-m-d')
            );
        } else {

            if ($this->searchTerm) {

                $this->movies = $this->movieRepository->searchMovies($this->searchTerm);
            }
        }
    }

    public function render()
    {
        $branches = Branch::whereNull('deleted_at')->get();

        return view('livewire.website.movie-listing', [
            'branches' => $branches,
            'movies' => $this->movies,
        ]);
    }
}
