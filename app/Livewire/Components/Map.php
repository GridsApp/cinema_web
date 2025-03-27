<?php

namespace App\Livewire\Components;


use Livewire\Attributes\Modelable;
use Livewire\Component;

class Map extends Component
{    
    #[Modelable]
    public $value;
    public $info;
    

    public function render()
    {
        
   
     
        return view('components.form.map');
    }
}
