<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Phone extends Component
{
    #[Modelable]
    public $value;



    public function render()
    {

        return view('components.form.phone');
    }
}
