<?php

namespace App\Repositories;

use App\Interfaces\OTPRepositoryInterface;

class OTPRepository implements OTPRepositoryInterface
{

    public function getDrivers()
    {
        return collect(config('otp-drivers'))->select('label', 'driver')->values()->toArray();
    }

    public function sendOTPByDriver($user, $driver, $otp)
    {
        // SEND BY DRIVER
        return true;
    }
}
