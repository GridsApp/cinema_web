<?php

namespace App\Livewire\Website;

use App\Interfaces\CardRepositoryInterface;
use Livewire\Component;

class ProfileInfo extends Component
{

    public $cinemaPrefix;
    public $langPrefix;
    public $user;


    public $walletBalance;
    public $loyaltyBalance;

    private CardRepositoryInterface $cardRepository;


    public function __construct()
    {
        $this->cardRepository = app(CardRepositoryInterface::class);
    }
    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        $this->loadUserData();
    }

    public function hydrate()
    {
        $this->dispatch('initPhoneNumber');
    }

    public function loadUserData()
    {
        $this->user = session('user');
        


        $this->walletBalance = $this->cardRepository->getWalletBalance($this->user);


        $this->walletBalance = currency_format($this->walletBalance);


        $this->loyaltyBalance = $this->cardRepository->getLoyaltyBalance($this->user);
    }


    

    public function render()
    {
        return view('livewire.website.profile-info');
    }
}
