<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use twa\cmsv2\Traits\APITrait;

class WalletController extends Controller
{
    use APITrait;
    private CartRepositoryInterface $cartRepository;
    private CardRepositoryInterface $cardRepository;
    private OrderRepositoryInterface $orderRepository;


    public function __construct(
        CartRepositoryInterface $cartRepository,
        CardRepositoryInterface $cardRepository,
        OrderRepositoryInterface $orderRepository,

    ) {
        $this->cartRepository = $cartRepository;
        $this->cardRepository = $cardRepository;
        $this->orderRepository = $orderRepository;
    }

    public function walletTopup()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['card_number', 'amount', 'payment_method_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;


        try {
            $system_id = get_system_from_type($user_type);
        } catch (\Throwable $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }
       

        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $system_id);
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }

        try {
            $this->cardRepository->getCardByBarcode($form_data['card_number']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Card number already exists', "This card number already exists"));
        }

        try {
            $this->cartRepository->addCardNumberToCart($cart->id, $form_data['card_number']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding Card Number to cart', $th->getMessage()));
        }


        $minimum_recharge_amount = get_setting("minimum_topup_amount");
        $maximum_recharge_amount =  get_setting("maximum_topup_amount");

        // dd($maximum_recharge_amount);

        if ($form_data['amount'] < $minimum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount greater than " . $minimum_recharge_amount));
        }
        if ($form_data['amount'] > $maximum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount less than " . $maximum_recharge_amount));
        }



        try {
            $this->cartRepository->addTopupToCart($cart->id, $form_data['amount']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding amount to cart', $th->getMessage()));
        }



        try {
            $payment_method = $this->orderRepository->getPaymentMethodById($form_data['payment_method_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Payment Method Not Found', $th->getMessage()));
        }

       
        if(!in_array($payment_method->key , ['CASH','CC-DC-QI-CARD','CC-DC-SWITCH'])){
            return $this->response(notification()->error('Payment Method Not Supported', 'Payment Method Not Supported'));
        }


        try {
            $order = app(\App\Http\Controllers\API\OrderController::class);
            return $order->createOrder($cart->id, $payment_method);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order Attempt Failed', $e->getMessage()));
        }

        
    }


   
}
