<?php

namespace App\Livewire\EntityForms;

use App\Models\Movie;
use App\Repositories\IMDBRepository;
use twa\cmsv2\Traits\FormTrait;
use twa\cmsv2\Traits\ToastTrait;
use Livewire\Component;

class MovieForm extends Component
{
    use FormTrait , ToastTrait;



    public function generateKey(){

        do {
            $nbr = random_int(1000000, 9999999);
        } while (Movie::where("movie_key", "=", $nbr)->first() instanceof Movie);

        $prefix = str(env('APP_NAME'))->explode(" ")->map(function($str){
            return str($str[0])->upper();
        })->values()->implode("");

        $this->form["movie_key"] = $prefix.$nbr;
    }
    public  function handleFetch()
    {

        if(empty($this->form["movie_key"])){
            $this->sendError("Please enter Movie Key");
            return;
        }

       $IMDBRepository = (new IMDBRepository);
       $response = $IMDBRepository->query($this->form["movie_key"]);

       if(isset($response['error']) && $response['error']){
           $this->sendError($response['message']);
           return;
       }

       $final_array = [...$this->form , ...$response];
       $this->resetForm((object) $final_array);
    }
    public function render()
    {

  

        return view('pages.form.components.movie-form');
    }

}
