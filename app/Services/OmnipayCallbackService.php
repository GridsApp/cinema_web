<?php

namespace App\Services;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;

class OmnipayCallbackService {



    private CardRepositoryInterface $cardRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(CardRepositoryInterface $cardRepository , OrderRepositoryInterface $orderRepository)
    {
        $this->cardRepository = $cardRepository;
        $this->orderRepository = $orderRepository;
    }


    public function callback($payment_attempt){

       return  $this->completePurchase($payment_attempt);
        // switch($payment_attempt->action){
            // case "RECHARGE_WALLET": return $this->rechargeWallet($payment_attempt);
            // case "COMPLETE_ORDER": return $this->completePurchase($payment_attempt);
        // }
      
        // return true;
    }


    public function rechargeWallet($payment_attempt){

        try {
            $this->cardRepository->createWalletTransaction("in" , $payment_attempt->amount , $payment_attempt->user , "Recharge wallet" , $payment_attempt->id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
   
    }

    public function completePurchase($payment_attempt){

        try {
         $order=   $this->orderRepository->createOrderFromCart($payment_attempt);
            return $order;
        } catch (\Throwable $th) {
            return null;
        }

    }

}