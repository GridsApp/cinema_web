<?php

namespace App\Livewire\Components;


use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class CommissionSettings extends Component
{
    #[Modelable]
    public $value;
    public $info;



    public function getData($id){

        if(!$id){
            return response()->json([
                'defaultPercentage' => "",
                'conditions' => [""],
            ]);
        }

        $distributor =  DB::table('distributors')->where('id' , $id)->first();

        if(!$distributor){
            return response()->json([
                'defaultPercentage' => "",
                'conditions' => [""],
            ]);
        }

        if(!$distributor->commission_settings){
            return response()->json([
                'defaultPercentage' => "",
                'conditions' => [""],
            ]);
        }

        $this->value = json_decode($distributor->commission_settings , 1);

        return response()->json([
            'defaultPercentage' => $this->value['defaultPercentage'],
            'conditions' => $this->value['conditions'],
        ]);
    }

    public function render()
    {

        return view('components.form.commission-settings');
    }
}
