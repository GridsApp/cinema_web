<?php

namespace App\Livewire\Components;

use App\Models\PriceGroupZone;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class TheaterMap extends Component
{    
    #[Modelable]
    public $value;
    public $info;
    

    public function getZones($id){

 
        $zones = PriceGroupZone::select('id' , 'label' , 'color' , 'default')->where('price_group_id' , $id)->whereNull('deleted_at')->get();

        return response()->json($zones);

    }

    public function render()
    {
        

        
        return view('components.form.theater-map');
    }
}
