<?php

namespace App\Entities;


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
        $this->addColumn("label",['translatable'=>true] );
        $this->addColumn("image" );
        $this->addColumn("description",['translatable'=>true]);
        $this->addColumn("latitude" );
        $this->addColumn("longitude" );
        $this->addColumn("address" ,['translatable'=>true]);
        $this->addColumn("number" );
        return $this->columns;
    }


}
