<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CouponsEntity extends Entity
{

    public $entity = "Coupons";
    public $tableName = "coupons";
    public $slug = "coupons";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("code" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("discount_flat" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("expires_at" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("coupon_used_at" , ["container" => 'col-span-7']);
        $this->addField("coupon_order_id" , ["container" => 'col-span-7']);
    

        return $this->fields;
    }

    public function columns(){
        
        $this->addColumn("label");
        $this->addColumn("code");
        $this->addColumn("discount_flat");
        $this->addColumn("expires_at");
    
        return $this->columns;
    }


}
