<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartsEntity extends Entity
{

    public $entity = "Carts";
    public $tableName = "carts";
    public $slug = "carts";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){
        $this->addField("card_number" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("user_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("pos_user_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("coupon_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("system" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("expires_at" , ["container" => 'col-span-6', 'required' => true]);
  
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("card_number");
        $this->addColumn("user_id" );
      
        return $this->columns;
    }


}
