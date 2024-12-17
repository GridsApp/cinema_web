<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartTopupsEntity extends Entity
{

    public $entity = "Cart Top Ups";
    public $tableName = "cart_topups";
    public $slug = "cart-topups";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("cart_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("amount" , ["container" => 'col-span-6', 'required' => true]);
  
        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


}
