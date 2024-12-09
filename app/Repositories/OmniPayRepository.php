<?php

namespace App\Repositories;

use App\Interfaces\OmniPayRepositoryInterface;
use App\Models\PaymentAttempt;

class OmniPayRepository implements OmniPayRepositoryInterface
{

    public function createPayment($payment_attempt) {


        // ROUTE WILL BE REDIRECTED BASES ON PAYMENT METHOD ID


        return route('payment.callback' , ['payment_attempt_id' =>  $payment_attempt->id]);
    }

    public function checkPayment($payment_attempt)
    {

        return true;
    }
}
