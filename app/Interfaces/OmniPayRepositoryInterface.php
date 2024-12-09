<?php

namespace App\Interfaces;

interface OmniPayRepositoryInterface 
{
    public function createPayment($payment_attempt);
    public function checkPayment($payment_attempt);

}