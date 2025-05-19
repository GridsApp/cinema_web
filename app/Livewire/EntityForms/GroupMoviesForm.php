<?php

namespace App\Livewire\EntityForms;

use App\Models\Branch;
use App\Models\GroupMovie;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use twa\cmsv2\Traits\FormTrait;



class GroupMoviesForm extends Component
{

    use FormTrait;


    public $family_group_id;

    public $form;
  
    public $uniqeid;
    public $branch_prices = [];

    public $branches = [];

 

    public function mount()
    {

        $this->form = [
            'movie_ids' =>[],
            'group_id' =>null,
           
        ];


      
    }



    public function add()
    {
     
        $this->validate([
            'form.movie_ids' => 'required|array',
            'form.group_id' => 'required'
        ]);


       foreach($this->form['movie_ids'] ?? [] as $movie_id){

        $GroupMovie = GroupMovie::where('group_id' , $this->form['group_id'])->where('movie_id' , $movie_id)->first();
        if(!$GroupMovie){
                $GroupMovie = new GroupMovie;
        }

        $GroupMovie->group_id = $this->form['group_id'];
        $GroupMovie->movie_id =$movie_id;
        $GroupMovie->save();

    }

 
    $this->dispatch('movies-added-to-group');

    $this->sendSuccess('Successfully Added','Movies are added to the group');

    

    $this->resetForm();



    }

    public function resetForm() {
        $this->form = [
            'movie_ids' => [],
            'group_id' => null,
        ];
    }
    public function render()
    {

        
        return view('pages.form.components.group-movies-form');
    }

}
