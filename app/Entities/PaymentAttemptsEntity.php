<?php

namespace App\Entities;


class PaymentAttemptsEntity extends Entity
{

    public $entity = "Payment Attempts";
    public $tableName = "payment_attempts";
    public $slug = "payment-attempts";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("reference", ["container" => 'col-span-7']);
        $this->addField("amount", ["container" => 'col-span-7']);
        $this->addField("payment_method_id", ["container" => 'col-span-7']);
        $this->addField("completed_at", ["container" => 'col-span-7']);
        $this->addField("converted_at", ["container" => 'col-span-7']);
        $this->addField("action", ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns()
    {
    
        return $this->columns;
    }

    public function callback(){


        dd("here");

    }

   
}
