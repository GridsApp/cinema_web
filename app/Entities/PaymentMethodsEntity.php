<?php

namespace App\Entities;


class PaymentMethodsEntity extends Entity
{

    public $entity = "Payment Methods";
    public $tableName = "payment_methods";
    public $slug = "payment-methods";

    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("label", ["container" => 'col-span-7']);
        $this->addField("image", ["container" => 'col-span-7']);

        return $this->fields;
    }

    public function columns()
    {
        return $this->columns;
    }
}
