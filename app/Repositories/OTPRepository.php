<?php

namespace App\Repositories;

use App\Interfaces\OTPRepositoryInterface;
use App\Mail\PasswordResetOTPMail;
use Illuminate\Support\Facades\Mail;

class OTPRepository implements OTPRepositoryInterface
{

    public function getDrivers()
    {
        return collect(config('otp-drivers'))->select('label', 'driver')->values()->toArray();
    }

    public function sendOTPByDriver($user, $driver, $otp)
    {
        // SEND BY DRIVER


        switch($driver){
            case "mail" : 

                Mail::to($user->email)->send(new PasswordResetOTPMail($user->email , $otp));
                // Send Email

            break;
        }


        return true;
    }
}
