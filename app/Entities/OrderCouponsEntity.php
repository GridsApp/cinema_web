<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;


class OrderCouponsEntity extends Entity
{

    public $entity = "Order Coupons";
    public $tableName = "order_coupons";
    public $slug = "order-coupons";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("order_id", ["container" => 'col-span-6']);
        $this->addField("amount", ["container" => 'col-span-6']);
        $this->addField("coupon_id", ["container" => 'col-span-6', 'required' => true]);


        return $this->fields;
    }

    public function columns()
    {

        $this->addColumn("order_id");
        $this->addColumn("price");
        $this->addColumn("label");
        return $this->columns;
    }
}
