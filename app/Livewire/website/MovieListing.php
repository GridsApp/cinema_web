<?php

namespace App\Livewire\Website;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Branch;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class MovieListing extends Component
{
    public $selectedBranch;
    public $searchTerm;
    public $movies = [];
     public $cinemaPrefix;
    public $languagePrefix;


    private MovieRepositoryInterface $movieRepository;
    private BranchRepositoryInterface $branchRepository;

    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
        $this->branchRepository = app(BranchRepositoryInterface::class);
    }

    public function mount()
    {
      
        $this->selectedBranch = null;
        $this->searchTerm = '';
        $this->movies = [];

        // Get the branch prefix from the URL (e.g., 'dbaye' from /dbaye/en/movies/listing)
        $branchPrefix = Request::segment(1); // This will get the first segment, which should be the branch (e.g., 'dbaye')

        // Find the branch by its prefix
        $branch = Branch::where('web_prefix', $branchPrefix)->first(); // Assuming the 'prefix' column stores the branch identifier
        if ($branch) {
            $this->selectedBranch = $branch->id; // Set the selected branch to its ID
        }
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
        return view('livewire.website.movie-listing', [
            'branches' => $this->branchRepository->getBranches(),
            'movies' => $this->movies,
        
        ]);
    }
    
    
}
