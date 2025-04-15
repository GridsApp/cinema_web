<?php

namespace App\Livewire\EntityForms;

use Carbon\CarbonPeriod;
use Livewire\Component;
use App\Models\MovieShow;
use App\Models\Movie;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use App\Rules\TimeConflictRule;
use Illuminate\Support\Facades\DB;
use twa\uikit\Traits\ToastTrait;


class PriceGroupZoneForm extends Component
{
    use ToastTrait;

    public $form;
    public $price_group_id = null;

    public $zone_id = null;

    public $uniqeid;

    public function resetForm($data = null)
    {

        // dd($data);
        $fields = [
            'label',
            'condensed_label',
            'iso',
       

            'color',
            // 'default',
            'price_settings',
        ];

        foreach ($fields as $field) {
            $info = config('fields.' . $field);

            if (!isset($info['name'])) {
                continue;
            }

            // $data = new \stdClass();
         
            $this->form[$info['name']] = field_init($info, $data);
        }
    }


    public function mount()
    {
        $zone = null;

        if($this->zone_id){
          $zone = DB::table('price_group_zones')->find($this->zone_id);
        }

        $this->resetForm($zone);
    }



   


    public function save()
    {
        $required_array = [
            'form.label' => 'required',
            'form.condensed_label' => 'required',
            'form.iso' => 'required',
            'form.color' => 'required',
            'form.price_settings' => 'required'
        ];

        $required_messages = [
            'form.label' => 'label',
            'form.condensed_label' => 'condensed label',
            'form.iso' => 'iso',

            'form.color' => 'color',
            'form.price_settings' => 'price settings',

        ];

        $this->validate($required_array, [], $required_messages);



        if($this->zone_id){
    
            $price_group_zone = PriceGroupZone::find($this->zone_id);
        }else{
            $price_group_zone = new PriceGroupZone();
            $price_group_zone->default = 0; 
            $price_group_zone->price_group_id = $this->price_group_id;
        }

        $price_group_zone->label = $this->form['label'];
        $price_group_zone->condensed_label =  $this->form['condensed_label'];
        $price_group_zone->iso =  $this->form['iso'];
        $price_group_zone->color =  $this->form['color'];
        $price_group_zone->price_settings =  $this->form['price_settings'];      
        $price_group_zone->save(); 


        return $this->redirect(route('price-group-zones' , ['id' => $this->price_group_id]) , navigate: true);
    
        // $this->resetForm();
        // $this->dispatch('record-created-' . $this->uniqeid);
        // $this->sendSuccess("Created", "Record successfully created");
    }
    public function render()
    {

        
        return view('pages.form.components.price-group-zone-form');
    }

}
