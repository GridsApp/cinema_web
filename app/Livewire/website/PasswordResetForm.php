<?php

namespace App\Livewire\Website;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PasswordResetForm extends Component
{

    public $password;
    public $confirm_password;
    public $phone;

    public $cinemaPrefix;
    public $langPrefix;

    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryInterface::class);
    }

    protected $rules = [
        'password' => 'required|min:8|regex:/[A-Za-z]/',
        'confirm_password' => 'required|same:password',
    ];


    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        $this->phone = session('phone_number');
    
    }

    public function resetPassword()
    {

        $this->validate();

        try {
            $user = $this->userRepository->getUserByPhone($this->phone);
            $user->password = Hash::make($this->password);
            $user->save();

            session()->forget('phone');
            session()->flash('success', 'Password has been reset successfully.');

            return redirect()->route('home', [
                'cinema_prefix' => $this->cinemaPrefix,
                'language_prefix' => $this->langPrefix,
            ]);
  
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.website.password-reset-form');
    }
}
