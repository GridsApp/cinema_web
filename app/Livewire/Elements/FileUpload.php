<?php

namespace App\Livewire\Elements;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\WithFileUploads;

class FileUpload extends Component
{

    use WithFileUploads;

    #[Modelable]
    public $value;

    public $file = [];
    public $info;


    


    public function render()
    {

        return view('components.form.file-upload');
    }


    public function save(){
        dd($this->value);
    }

}
