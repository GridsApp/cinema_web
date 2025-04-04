<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class BrancheItemsEntity extends Entity
{

    public $entity = "Branch Items";
    public $tableName = "branch_items";
    public $slug = "branch-items";

    public $params = [
        'pagination' => 20,
    ];
  

    public function fields(){


        $this->addField("branch" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("predefined_item_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("hide" , ["container" => 'col-span-12']);
    


        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


    public function filters(){
     
        // $this->addFilter("display");

        return $this->filters;
    }



}
