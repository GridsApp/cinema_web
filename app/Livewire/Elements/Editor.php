<?php

namespace App\Livewire\Elements;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Editor extends Component
{    
    #[Modelable]
    public $value;
    public $info;
    
    public function render()
    {
        return view('components.form.editor');
    }
}
