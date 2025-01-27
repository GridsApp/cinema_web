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

    public $queryString = ['searchTerm' => ['except' => '']];

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
        $this->movies = [];
    
        $branchPrefix = Request::segment(1);
        $branch = Branch::where('web_prefix', $branchPrefix)->first();
    
        if ($branch) {
            $this->selectedBranch = $branch->id;
        }
    
        $this->filterMovies(); // Initial load based on selected branch
    }
    

    public function updatedSelectedBranch($value)
    {
        $branch = Branch::find($value);

        if ($branch && $branch->web_prefix) {
            $this->dispatch('changeUrl', ['webPrefix' => $branch->web_prefix]);
        } else {
            $this->dispatch('changeUrl', ['webPrefix' => 'dbaye']);
        }
    }
    public function filterMovies()
    {
        
        if ($this->selectedBranch) {
            $this->movies = collect($this->movieRepository->getBranchActiveMovies(
                $this->selectedBranch,
                now()->format('Y-m-d')
            ));
        }
    
        if ($this->searchTerm) {
         
            $this->movies = collect($this->movies)->filter(function ($movie) {
                return stripos($movie['name'], $this->searchTerm) !== false; // Case-insensitive search
            });
        }
    }
    
    
    

    public function updatedSearchTerm()
    {
        $this->filterMovies();
    }

    public function render()
    {
        return view('livewire.website.movie-listing', [
            'branches' => $this->branchRepository->getBranches(),
            'movies' => $this->movies,
        ]);
    }
}
