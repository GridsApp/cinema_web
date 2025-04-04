<?php

namespace App\Entities;


use twa\cmsv2\Entities\Entity;

class OrderItemsEntity extends Entity
{

    public $entity = "Order Items";
    public $tableName = "order_items";
    public $slug = "order-items";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){
        
        $this->addField("branch_item_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("item_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("order_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("label" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-6', 'required' => true]);
     
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("item_id");
        $this->addColumn("order_id");
        $this->addColumn("price");
        $this->addColumn("label");
        return $this->columns;
    }


}
