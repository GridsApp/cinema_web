<?php

namespace App\Interfaces;

interface OTPRepositoryInterface 
{
    public function sendOTPByDriver($user, $driver, $otp);
    public function getDrivers();
}