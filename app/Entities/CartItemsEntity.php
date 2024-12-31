<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartItemsEntity extends Entity
{

    public $entity = "Cart Items ";
    public $tableName = "cart_items";
    public $slug = "cart-items";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("item_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("cart_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price", ["container" => 'col-span-6', 'required' => true]);
       
        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


}
