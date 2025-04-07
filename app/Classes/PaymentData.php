<?php

namespace App\Classes;


class PaymentData
{

   public $reference;
   public $amount;
   public $currency;
   public $phone;
   public $customer_name;
   public $customer_email;
   public $reference_prefix;
   public $success_callback;
   public $customer_id;


    public function setReference($reference){
        $this->reference= $reference;
        return $this;
    }

    public function setPhone($phone){
        $this->phone= $phone;
        return $this;
    }

    public function setReferencePrefix($reference_prefix){
        $this->reference_prefix= $reference_prefix;
        return $this;
    }
    public function setAmount($amount){
        $this->amount = round($amount, 2);
        return $this;
    }
    public function setCurrency($currency){
        $this->currency = $currency;
        return $this;
    }
    public function setCustomerName($first_name , $last_name =  ""){
        $this->customer_name = $first_name . " ". $last_name;
        return $this;
    }

    public function setCustomerEmail($email){
        $this->customer_email = $email;
        return $this;
    }

    public function setSuccessCallback($success_callback){
        $this->success_callback = $success_callback;
        return $this;
    }

    public function setCustomerId($customer_id){
        $this->customer_id = $customer_id;
        return $this;
    }
}
