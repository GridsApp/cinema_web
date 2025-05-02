<?php

namespace App\Livewire\Components;


use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class PriceSettings extends Component
{
    #[Modelable]
    public $value;
    public $info;


    public function render()
    {



        return view('components.form.price-settings');
    }
}
