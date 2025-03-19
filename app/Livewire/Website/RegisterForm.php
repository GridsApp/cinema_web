<?php

namespace App\Livewire\Website;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class RegisterForm extends Component
{
    use ToastTrait;
    private UserRepositoryInterface $userRepository;
    private CardRepositoryInterface $cardRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryInterface::class);
        $this->cardRepository = app(CardRepositoryInterface::class);
    }

    public $cinemaPrefix;
    public $langPrefix;
   
    public $password;
  
    public $confirm_password;
    public $agree;

    public $phone_country_code;
    public $phone_number;
    public $phone;

    protected $rules = [
        'phone' => ['required', 'regex:/^\+?[0-9]+$/'],
        'password' => 'required|min:8|regex:/[A-Za-z]/',
        'confirm_password' => 'required|same:password',
    ];



    protected $messages = [
        'phone.required' => 'The phone number field is required.',
        'phone.regex' => 'The phone number format is invalid. It must start with "+" followed by numbers.',
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must have at least 8 characters.',
        'password.regex' => 'The password must contain at least one letter.',
        'confirm_password.same' => 'The confirm password field must match password..',
        'confirm_password.required' => 'The confirm password field is required.',

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

    public function submit()
    {
// dd($this->phone);

        $this->validate();

        try {
            $user = $this->userRepository->getUserByPhone($this->phone);
            dd($user);
            $this->sendError("You are already registered user", "You are already registered user");
            return;
        } catch (\Exception $e) {
            $user = $this->userRepository->createUser($this->phone, $this->password);
            $this->sendSuccess("Registered Successfully ", "Registered Successfully");
        }

        $this->cardRepository->createCard($user);

        return redirect()->route('login-web', [
            'cinema_prefix' => $this->cinemaPrefix,
            'language_prefix' => $this->langPrefix,
        ]);
    }

    public function render()
    {
        return view('livewire.website.register-form');
    }
}
