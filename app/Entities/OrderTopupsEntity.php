<?php

namespace App\Entities;


class OrderTopupsEntity extends Entity
{

    public $entity = "Order Topups";
    public $tableName = "order_topups";
    public $slug = "order-topups";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){
      
        $this->addField("label" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("order_id" , ["container" => 'col-span-6', 'required' => true]);
     

  
        return $this->fields;
    }

    public function columns(){
 
        $this->addColumn("order_id");
        $this->addColumn("price");
        $this->addColumn("label");
        return $this->columns;
    }


}
