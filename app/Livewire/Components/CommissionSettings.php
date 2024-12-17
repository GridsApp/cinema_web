<?php

namespace App\Livewire\Components;


use Livewire\Attributes\Modelable;
use Livewire\Component;

class CommissionSettings extends Component
{    
    #[Modelable]
    public $value;
    public $info;
    

   
    public function render()
    {
        
        return view('components.form.commission-settings');
    }
}
