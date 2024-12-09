<?php

namespace App\Livewire\Elements;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Date extends Component
{
    #[Modelable]
    public $value;
    public $info;

    public function render()
    {
        return view('components.form.date');
    }
}
