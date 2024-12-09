<?php

namespace App\Entities;


class OrderSeatsEntity extends Entity
{

    public $entity = "Order Seats";
    public $tableName = "order_seats";
    public $slug = "order-seats";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){
        $this->addField("seat" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("label" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-6', 'required' => true]);

        $this->addField("order_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("discount" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("final_price" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("gained_points" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_at" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_cashier_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_manager_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("movie_show_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("zone_id" , ["container" => 'col-span-6', 'required' => true]);
      
  
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("order_id");
        $this->addColumn("price");
        $this->addColumn("label");
        return $this->columns;
    }


}
