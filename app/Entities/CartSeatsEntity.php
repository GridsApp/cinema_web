<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartSeatsEntity extends Entity
{

    public $entity = " Cart Seats ";
    public $tableName = "cart_seats";
    public $slug = "cart-seats";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("movie_show_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("zone_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("seat" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("cart_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("discount" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("final_price" , ["container" => 'col-span-6', 'required' => false]);

        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


}
