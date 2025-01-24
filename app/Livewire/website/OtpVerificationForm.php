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
    public $canResendOtp = false;
    public $remainingTime = 0;


    protected $rules = [
        'otp' => 'required|array|size:4',
        'otp.*' => 'required|digits:1',
    ];

    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;

        $this->resendAllowedAt = session('resend_allowed_at', now());
        $this->updateResendState();
    }

    public function updateResendState()
    {
        $latestUserPin = UserPin::whereHas('user', function ($query) {
            $query->where('phone', session('phone_number'));
        })
        ->orderByDesc('created_at')
        ->first();
    
        if ($latestUserPin) {
            $expiresAt = Carbon::parse($latestUserPin->expires_at);
    
        
            $remainingSeconds = Carbon::now()->diffInMinutes($expiresAt, false);
    
            // dd($remainingSeconds);
 
            if ($remainingSeconds > 0) {
                $this->canResendOtp = false;
                $this->remainingTime = $remainingSeconds;
            } else {
                $this->canResendOtp = true;
                $this->remainingTime = 0;
            }
        } else {
            $this->canResendOtp = true;
                        $this->remainingTime = 0;
        }
    }
    
    

    public function resendOtp()
    {
        $this->updateResendState();

        if (!$this->canResendOtp) {
            return;
        }

        $sessionPhone = session('phone_number');

        $user = UserPin::whereHas('user', function ($query) use ($sessionPhone) {
            $query->where('phone', $sessionPhone);
        })->first();

        if (!$user) {
            $this->addError('otp', 'User not found.');
            return;
        }

        $otp = random_int(1000, 9999);
        $expireAt = Carbon::now()->addMinutes(5);

        UserPin::create([
            'user_id' => $user->user_id,
            'code' => $otp,
            'expires_at' => $expireAt,
        ]);

        $this->resendAllowedAt = Carbon::now()->addMinutes(1);
        session(['resend_allowed_at' => $this->resendAllowedAt]);

        $this->updateResendState();
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
