<?php

namespace App\Livewire\EntityForms;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use twa\cmsv2\Traits\FormTrait;
use twa\uikit\Traits\ToastTrait;


class ItemForm extends Component
{

    use FormTrait;


    public $family_group_id;

    public $form;
  
    public $uniqeid;
    public $branch_prices = [];

    public $branches = [];

    public function resetForm()
    {

    }
 

    public function mount()
    {


        // dd($this->family_group_id);

        $this->branches = Branch::whereNull('deleted_at')->get();

        if($this->family_group_id){
         $items = DB::table('items')->where('family_group_id' , $this->family_group_id)->whereNull('deleted_at')->get();
        

         if($items[0]->screen_type_id){
            $screen_type_id =  json_decode($items[0]->screen_type_id,1);
         }else{
            $screen_type_id = [];
         }
        if(!is_array($screen_type_id)){
            $screen_type_id = [];        
        }

         $this->form = [
            'image' =>field_init(config('fields.image'), $items[0]),
            'label' => $items[0]->label,
            'screen_type_id' =>$screen_type_id ,
            'branch_id' => $items->pluck('branch_id')->toArray(),
        ];


    
        foreach($items as $item){
            $this->branch_prices[] = [
                'label' => ($this->branches)->where('id' , $item->branch_id)->first()->label ?? '',
                'branch_id' => $item->branch_id,
                'price' => $item->price,
                'id' => $item->id
            ];
        }

        
        }else{

       

        $this->form = [
            'image' => null,
            'label' => null,
            'screen_type_id' => [],
            'branch_id' => [],
        ];
        
        }

    }


    // #[On('branchchangedvalue')]
    public function loadPrices(){

        // dd($this->form["branch_id"]);
        // $this->branch_prices = [];

        

        foreach($this->form["branch_id"] as $branch_id){

            $already = collect($this->branch_prices)->where('branch_id' , $branch_id)->first();

            if($already){
                continue;
            }

            $this->branch_prices[] = [
                'id' => null,
                'label' => ($this->branches)->where('id' , $branch_id)->first()->label ?? '',
                'branch_id' => $branch_id,
                'price' => 0
            ];
        }

        $this->branch_prices = collect($this->branch_prices)->whereIn('branch_id' , $this->form["branch_id"])->toArray();


        

    }


   


    public function save()
    {
        
        // dd($this->form['branch_id']);
       

        $required_array = [
            'form.label' => 'required',
            // 'form.price' => 'required',
            'form.branch_id' => 'required',
            // 'form.screen_type_id' => 'required'
        ];

        $this->validate($required_array);


        $arr = [];
        $family = $this->family_group_id ? $this->family_group_id : uniqid();
        foreach($this->branch_prices as $branch_price){
            $screen_type_id = $this->form['screen_type_id'] ?? null;
            $screen_type_id = (is_array($screen_type_id) && count($screen_type_id) === 0) ? null : json_encode($screen_type_id);
    
            $arr [] = [
                    'id' => $branch_price['id'] ?? null,
                    'image' => field_value(config('fields.image'), $this->form),
                    'label' => $this->form['label'],
                    'price' => $branch_price['price'],
                    'branch_id' => $branch_price['branch_id'],
                    'screen_type_id' => $screen_type_id,
                    'family_group_id' => $family,
                    'created_at' => now(),
                    'updated_at' => now()
            ];
        } 


        $toDelete = collect($arr)->whereNull('id')->where('family_group_id' , $this->family_group_id)->pluck('branch_id');

        DB::table('items')->where('family_group_id' , $this->family_group_id)->whereIn('branch_id' , $toDelete)->update([
            'deleted_at' => now()
        ]);


        $inserted = DB::table('items')->upsert($arr, ['id'], ['image', 'label' , 'price' , 'branch_id' , 'created_at' , 'updated_at' , 'screen_type_id' , 'family_group_id']);

        

      
        return $this->redirect(route('items', ['family_group_id' => $this->family_group_id]), navigate: true);

    }
    public function render()
    {

        
        $this->loadPrices();

        return view('pages.form.components.item-form');
    }

}
