<?php

namespace App\Livewire\Website;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserPin;
use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;
use Carbon\Carbon;

class ForgotPasswordForm extends Component
{
    public $phone_country_code;
    public $phone_number;
    public $phone;
    public $cinemaPrefix;
    public $langPrefix;
    public $otpSent = false;


    protected $rules = [
        'phone' => 'required', 
    ];


    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        $this->dispatch('initPhoneNumber');
       
    }

    public function hydrate()
    {
        $this->dispatch('initPhoneNumber');
    }
    public function sendOtp()
    {
        $this->validate();


        $user = User::where('phone', $this->phone_number)->first();

        if (!$user) {
            $this->addError('phone', 'User not found.');
            return;
        }


        $otp = random_int(1000, 9999);
        $expireAt = Carbon::now()->addMinutes(1);


        UserPin::create([
            'user_id' => $user->id,
            'code' => $otp,
            'expires_at' => $expireAt,
        ]);

        $this->otpSent = true;

        session(['otp' => $otp, 'phone_number' => $this->phone_number]);
        return redirect()->route('otp-verify', [
            'cinema_prefix' => $this->cinemaPrefix,
            'language_prefix' => $this->langPrefix,
        ]);
    }
  
    public function render()
    {
        return view('livewire.website.forgot-password-form');
    }
}
