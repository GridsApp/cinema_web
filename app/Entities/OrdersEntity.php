<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class OrdersEntity extends Entity
{

    public $entity = "Orders";
    public $tableName = "orders";
    public $slug = "orders";


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
        // $this->addField("total_price" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("long_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("printed_at" , ["container" => 'col-span-6', 'required' => true]);
  
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("user_id");
        $this->addColumn("system");
        $this->addColumn("reference");
       
        return $this->columns;
    }


}
