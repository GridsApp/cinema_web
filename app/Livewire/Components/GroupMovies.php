<?php

namespace App\Livewire\Components;

use App\Models\GroupMovie;
use Livewire\Component;
use App\Models\Movie;
use App\Models\MovieShow;
use Carbon\CarbonPeriod;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use twa\uikit\Traits\ToastTrait;

class GroupMovies extends Component
{

    use ToastTrait;


    public $grouped_movies = [];



    public function mount()
    {
        $this->loadMovies();
    }

    #[On('movies-added-to-group')]
    public function loadMovies()
    {

        $this->grouped_movies = GroupMovie::whereNull('deleted_at')->get()->map(function ($item) {

            return [
                'group' => $item->group->label ?? '',
                'movie' => $item->movie->condensed_name ?? '',
                'id' => $item->id
            ];
        })->groupBy('group');
    }

    public function deleteMovie($id)
    {
        $movie = GroupMovie::find($id);

        if ($movie) {
            $movie->delete();
            $this->sendSuccess("Removed Successfully", "Movie removed from group.");
        } else {

            $this->sendSuccess("Not Able To Remove", "Movie not found");
        }

        $this->loadMovies();
    }


    public function render()
    {





        return view('components.form.group-movies', []);
    }
}
