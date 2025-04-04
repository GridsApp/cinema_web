<?php

namespace App\Livewire\EntityForms;

use App\Models\BranchItem;
use Carbon\CarbonPeriod;
use Livewire\Component;
use App\Models\MovieShow;
use App\Models\Movie;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use App\Rules\TimeConflictRule;
use Illuminate\Support\Facades\DB;
use twa\uikit\Traits\ToastTrait;


class BranchItemForm extends Component
{
    use ToastTrait;

    public $form;
    public $branch_id = null;

    public $item_id = null;

    public $uniqeid;

    public function resetForm($data = null)
    {

        // dd($data);
        $fields = [
            'predefined_item_id',
            'hide',
            'price',
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
        $item = null;

        if($this->item_id){
          $item = DB::table('branch_items')->find($this->item_id);
        }

        $this->resetForm($item);
    }



   


    public function save()
    {
        $required_array = [
            'form.item_id' => 'required',
            'form.price' => 'required',
           
        ];

        $required_messages = [
            'form.item_id' => 'item',
            'form.price' => 'price',
        ];

        $this->validate($required_array, [], $required_messages);


        if($this->item_id){
            $branch_item = BranchItem::find($this->item_id);
        }else{
            $branch_item = new BranchItem();
            $branch_item->branch_id = $this->branch_id;
        }

        $branch_item->item_id = $this->form['item_id'];
        $branch_item->price =  $this->form['price'];
        $branch_item->hide =  $this->form['hide'] ?? 0;
        $branch_item->save(); 


        return $this->redirect(route('branch-items' , ['id' => $this->branch_id]) , navigate: true);

    }
    public function render()
    {

        
        return view('pages.form.components.branch-item-form');
    }

}
