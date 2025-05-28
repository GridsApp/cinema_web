<?php

namespace App\Repositories;

use App\Interfaces\OTPRepositoryInterface;
use App\Mail\PasswordResetOTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OTPRepository implements OTPRepositoryInterface
{

    public function getDrivers()
    {
        return collect(config('otp-drivers'))->select('label', 'driver')->values()->toArray();
    }

    public function sendOTPByDriver($user, $driver, $otp)
    {
        try {
            switch($driver){
                case "mail" : 
                    Log::info('Attempting to send OTP email to: ' . $user->email);
                    Mail::to($user->email)->send(new PasswordResetOTPMail($user->email , $otp));
                    Log::info('OTP email sent successfully');
                    // Send Email
                    break;
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            throw $e;
        }
    }
}
