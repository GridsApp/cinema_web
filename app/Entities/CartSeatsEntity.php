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
        $this->addField("movie" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("screen_type" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("theater" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("date" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("time_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("week" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("time" , ["container" => 'col-span-6', 'required' => true]);
        
        
        $this->addField("zone_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("seat" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("cart_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("imtiyaz_phone" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("reward_code" , ["container" => 'col-span-6']);
        
        
        // $this->addField("discount" , ["container" => 'col-span-6', 'required' => false]);
        // $this->addField("final_price" , ["container" => 'col-span-6', 'required' => false]);
        // $this->addField("discount_type", ["container" => 'col-span-6', 'required' => true]);


        return $this->fields;
    }

    public function columns(){
      
        return $this->columns;
    }


}
