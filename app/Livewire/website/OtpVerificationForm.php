<?php

namespace App\Livewire\Website;

use App\Models\UserPin;
use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;
use Carbon\Carbon;

class OtpVerificationForm extends Component
{
   
    public $cinemaPrefix;
    public $langPrefix;

    public $otp = [];
    public $resendAllowedAt;
    
    protected $rules = [
        'otp' => 'required|array|size:4',
        'otp.*' => 'required|digits:1',
    ];
    

    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|array|size:4', 
            'otp.*' => 'digits:1',           
        ]);

        $sessionPhone = session('phone_number');
        $otpCode = implode('', $this->otp); 

        $userPin = UserPin::whereHas('user', function ($query) use ($sessionPhone) {
            $query->where('phone', $sessionPhone);
        })->where('code', $otpCode)->orderByDesc('created_at')->first();

        if (!$userPin || !$userPin->expires_at || Carbon::now()->gt($userPin->expires_at)) {
            $this->addError('otp', 'The OTP is invalid or has expired.');
            return;
        }

        session()->forget(['otp', 'phone']);

        return redirect()->route('password-reset', [
            'cinema_prefix' => $this->cinemaPrefix,
            'language_prefix' => $this->langPrefix,
        ]);
    }
    public function render()
    {
        return view('livewire.website.otp-verification-form');
    }
}
