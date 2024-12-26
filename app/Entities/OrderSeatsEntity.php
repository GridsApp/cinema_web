<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

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
        $this->addField("discount" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("final_price" , ["container" => 'col-span-6', 'required' => false]);

        $this->addField("order_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("gained_points" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_at" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_cashier_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("refunded_manager_id" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("movie_show_id" , ["container" => 'col-span-6', 'required' => true]);
      
        $this->addField("movie" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("screen_type" , ["container" => 'col-span-7']);       
        $this->addField("theater" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("date" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("time" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("week" , ["container" => 'col-span-7']);

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
