<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class OrdersEntity extends Entity
{

    public $entity = "User Orders";
    public $tableName = "user_orders";
    public $slug = "user-orders";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){
        $this->addField("user_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("pos_user_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("system" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("reference" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("barcode" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("payment_method_id" , ["container" => 'col-span-6', 'required' => true]);
  
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("completed",['translatable'=>true] );
        $this->addColumn("system",['translatable'=>true] );
        $this->addColumn("reference_id",['translatable'=>true] );
       
        return $this->columns;
    }


}
