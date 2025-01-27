<?php

namespace App\Livewire\Website;

use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;
use Illuminate\Support\Facades\Hash;

class SignInForm extends Component
{
    use ToastTrait;

    private UserRepositoryInterface $userRepository;
    private TokenRepositoryInterface $tokenRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryInterface::class);
        $this->tokenRepository = app(TokenRepositoryInterface::class);
    }

    public $cinemaPrefix;
    public $langPrefix;


    public $password;

    public $phone_country_code;
    public $phone_number;
    public $phone = '';
    protected $rules = [
        'phone' => ['required', 'regex:/^\+?[0-9]+$/'],

        'password' => 'required',
    ];

    protected $messages = [
        'phone.required' => 'The phone number is required.',
        'phone.regex' => 'The phone format must start with a "+" followed by numbers.',
        'password.required' => 'The password is required.',
        'password.min' => 'The password must be at least 8 characters long.',
        'password.regex' => 'The password must contain at least one letter.',
    ];

    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        // $this->dispatch('initPhoneNumber');
    }

    public function hydrate()
    {
        $this->dispatch('initPhoneNumber');
    }

    public function submit()
    {



        dd($this->phone);

        $this->validate();

        try {
            // dd($this->phone_number);
            $user = $this->userRepository->getUserByPhone($this->phone);
        } catch (\Exception $e) {

            $this->sendError("You have entered an invalid phone number", "Invalid phone");
            return;
        }


        if (!Hash::check($this->password, $user->password)) {

            $this->sendError("You have entered invalid credentials", "Invalid credentials");
            return;
        }


        session(['user' => $user]);


        return redirect()->route('home', [
            'cinema_prefix' => $this->cinemaPrefix,
            'language_prefix' => $this->langPrefix,
        ]);
    }

    public function render()
    {
        return view('livewire.website.sign-in-form');
    }
}
