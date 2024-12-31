<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CartCouponsEntity extends Entity
{

    public $entity = "Cart Coupons";
    public $tableName = "cart_coupons";
    public $slug = "cart-coupons";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("cart_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("coupon_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("amount", ["container" => 'col-span-6', 'required' => true]);
        
        return $this->fields;
    }

    public function columns()
    {

        return $this->columns;
    }
}
