<?php

namespace App\Livewire\EntityForms;

use Carbon\CarbonPeriod;
use Livewire\Component;
use App\Models\MovieShow;
use App\Models\Movie;
use App\Models\Theater;
use App\Rules\TimeConflictRule;
use twa\uikit\Traits\ToastTrait;


class MovieShowForm extends Component
{
    use ToastTrait;

    public $form;
    public $theater_id = null;
    public $date_from = null;
    public $date_to = null;
    public $time_id = null;
    public $uniqeid;

    public function resetForm($data = null)
    {
        $fields = [
            'movie',
            'date_from',
            'date_to',
            'time',
            'screen_type',
            'movie_show_color'

        ];

        foreach ($fields as $field) {
            $info = config('fields.' . $field);

            if (!isset($info['name'])) {
                continue;
            }

            $data = new \stdClass();
            $data->date_from = $this->date_from;
            $data->date_to = $this->date_to;

            $this->form[$info['name']] = field_init($info, $data);
        }
    }


    public function mount()
    {
        $this->resetForm();
    }



    public function render()
    {

        return view('pages.form.components.movie-show-form');
    }


    public function save()
    {
        $required_array = [
            'form.movie_id' => 'required',
            'form.screen_type_id' => 'required',
            'theater_id' => 'required',
            'form.date_from' => 'required',
            'form.date_to' => 'required',
            'form.time_id' => ['required'],
        ];

        $required_messages = [
            'form.movie_id' => 'movie',
            'form.screen_type_id' => 'screen type',
            'theater_id' => 'theater',
            'form.date_from' => 'date from',
            'form.date_to' => 'date to',
            'form.time_id' => 'time' ,
        ];

        $this->validate($required_array, [], $required_messages);


        $movie = Movie::find($this->form['movie_id']);

        if(!$movie){
            return;
        }


        //get week of a movie from movie_id , branch

        $theater = Theater::find($this->theater_id);

        $first_show_date = $this->getDateOfFirstMovieShowInBranch($this->form['movie_id'] , $theater->branch_id);

        $period = CarbonPeriod::create($this->form['date_from'], $this->form['date_to']);

        $required_array = [
            'form.time_id' => [ new TimeConflictRule($this->theater_id,  $period , $this->form['time_id'] , $movie->duration) ],
        ];

        $this->validate($required_array);
        
      
        $group = uniqid();;
      
       
        $slots = ceil($movie->duration / 15);;
        
        if(!$first_show_date){
            $first_show_date = $period->first() ?? null;
        }

        foreach ($period as $date) {
            $week = $this->calculateWeekNumber($date , $first_show_date);
            $movie_show =  new MovieShow;
            $movie_show->screen_type_id = $this->form['screen_type_id'];
            $movie_show->theater_id = $this->theater_id;
            $movie_show->movie_id = $this->form['movie_id'];
            $movie_show->time_id = $this->form['time_id'];
            $movie_show->end_time_id = $this->form['time_id'] + $slots - 1;
            $movie_show->duration = $movie->duration;
            $movie_show->date = $date;
            $movie_show->visibility = 1;
            // $movie_show->system_id = ["1"];
            $movie_show->group = $group;
            $movie_show->color = $this->form['color'];
            $movie_show->week = $week;
            $movie_show->save();
         
        }

        $this->resetForm();
        $this->dispatch('record-created-' . $this->uniqeid);
        $this->sendSuccess("Created", "Record successfully created");
    }


    public function getDateOfFirstMovieShowInBranch($movie_id , $branch_id){


        $theaters_ids = Theater::where('branch_id' , $branch_id)
        ->whereNull('deleted_at')
        ->pluck('id');

        $firstShow = MovieShow::where('movie_id' , $movie_id)->whereIn('theater_id' , $theaters_ids)
        ->orderBy('date' , 'ASC')
        ->orderBy('time_id' , 'ASC')
        ->first();

        return $firstShow->date ?? null;

    }

    

    public function calculateWeekNumber($current_date , $first_show_date = null){

        if(!$first_show_date){
            return 1;
        }

        $period = CarbonPeriod::create($first_show_date , $current_date)->count();


        // return intdiv($period , 8) + 1;
        return intdiv($period - 1, 7) + 1;

    //     $nb_mondays = 0;
    //     foreach($period as $date){
    //         if($date->isMonday()){
    //             $nb_mondays++;
    //         }
    //     }

    //    return $nb_mondays+1;
    }
}
