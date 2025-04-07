<?php

namespace App\Repositories;

use App\Interfaces\OmniPayRepositoryInterface;

use App\Repositories\PaymentGateways\Hyperpay;
use App\Repositories\PaymentGateways\Zaincash;

use App\Classes\PaymentData;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PaymentMethod;

class OmniPayRepository implements OmniPayRepositoryInterface
{


    private UserRepositoryInterface $userRepository;
    private OrderRepositoryInterface $orderRepository;
  


    public function __construct(UserRepositoryInterface $userRepository,OrderRepositoryInterface $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
      
    }

    public function createPayment($payment_attempt) {
       
        $payment_method =$this->orderRepository->getPaymentMethodById($payment_attempt->payment_method_id); 
        $user = $this->userRepository->getUserById($payment_attempt->user_id);

        $paymentData = (new PaymentData())
        ->setReference($payment_attempt->reference)
        ->setAmount($payment_attempt->amount)
        ->setCurrency("IQD")
        ->setCustomerName($user["name"])
        ->setCustomerEmail($user["email"])
        ->setPhone($user['phone'])
   
        ->setReferencePrefix("30")
        ->setCustomerId($payment_attempt->user_id);


        $data = config('omnipay.'.$payment_method->key.'.data');


        switch($payment_method->key){
            case 'OP-HY':
            case 'OP-HY-TEST':
              
                $class =  (new Hyperpay($data , $payment_method->key));
                break;

            case 'OP-ZC':
            case 'OP-ZC-TEST':
                $class =  (new Zaincash($data , $payment_method->key));
                break;

        }

        return $class->createPayment($payment_attempt , $paymentData)['redirect']['link'] ?? null;

    }

    public function checkPayment($payment_attempt)
    {

        $payment_method = PaymentMethod::find($payment_attempt->payment_method_id);

        if(!$payment_method){
            return false;
        }

        $data = config('omnipay.'.$payment_method->key.'.data');

        switch($payment_method->key){
            case 'OP-HY':
            case 'OP-HY-TEST':
                $class =  (new Hyperpay($data , $payment_method->key));
                break;

            case 'OP-ZC':
            case 'OP-ZC-TEST':
                $class =  (new Zaincash($data , $payment_method->key));
                break;
        }


        $check_payment_response =  $class->checkPayment($payment_attempt , request()->all());

        

        $check_payment = $check_payment_response->getOriginalContent();

        if ($check_payment_response->isSuccessful()) {
        
            $payment_attempt->converted_at = now();
            $payment_attempt->save();

            return true;
        }

        return false;
    }
}
