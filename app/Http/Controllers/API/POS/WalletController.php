<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;
use twa\cmsv2\Traits\APITrait;

class WalletController extends Controller
{
    use APITrait;
    private CartRepositoryInterface $cartRepository;
    private CardRepositoryInterface $cardRepository;


    public function __construct(
        CartRepositoryInterface $cartRepository,
        CardRepositoryInterface $cardRepository,

    ) {
        $this->cartRepository = $cartRepository;
        $this->cardRepository = $cardRepository;
    }

    public function walletTopup()
    {

        $user = request()->user;
        $user_type = request()->user_type;

        $form_data = clean_request([]);
        $system_id = get_system_from_type($user_type);

        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $system_id);
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }


        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'card_number', 'payment_method_id']);

        if ($check) {
            return $this->response($check);
        }

        try {
            $this->cardRepository->getCardByBarcode($form_data['card_number']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Card number already exists', "This card number already exists"));
        }

        try {
            $this->cartRepository->addCardNumberToCart($form_data['cart_id'], $form_data['card_number']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding Card Number to cart', $th->getMessage()));
        }

        try {
            $this->cartRepository->addTopupToCart($form_data['cart_id'], $form_data['amount']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding amount to cart', $th->getMessage()));
        }


        try {
            $order = app(\App\Http\Controllers\API\OrderController::class);
            return $order->attempt($user, $form_data['cart_id'], $form_data['payment_method_id']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order Attempt Failed', $e->getMessage()));
        }

        
    }
}
