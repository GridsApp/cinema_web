<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class PaymentAttemptLogsEntity extends Entity
{

    public $entity = "Payment Attempt logs";
    public $tableName = "payment_attempt_logs";
    public $slug = "payment-attempt-logs";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("payload", ["container" => 'col-span-7']);
        $this->addField("message" , ["container" => 'col-span-6', 'required' => false]);
        $this->addField("payment_attempt_id", ["container" => 'col-span-7']);
      
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
