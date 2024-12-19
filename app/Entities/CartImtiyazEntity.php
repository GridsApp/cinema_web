<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartImtiyazEntity extends Entity
{

    public $entity = "Cart Imtiyaz";
    public $tableName = "cart_imtiyaz";
    public $slug = "cart-imtiyaz";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("cart_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("phone" , ["container" => 'col-span-6', 'required' => true]);
  
        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


}
