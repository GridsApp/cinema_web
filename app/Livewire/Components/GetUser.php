<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class GetUser extends Component
{

    use ToastTrait;

    public $form = [];
    public $transactions = [];
    public $balance = 0;

    public $user;
    public $barcode = null;
    public $loyaltyBalance;
    public $loyaltyTransactions = [];

    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->cardRepository = app(CardRepositoryInterface::class);;
        $this->userRepository = app(UserRepositoryInterface::class);
    }


    public function mount()
    {

        $this->form['phone_email_card_number'] = null;
    }

    public function searchByCard()
    {
        $user = null;

        $this->validate([
            'form.phone_email_card_number' => 'required',

        ], [
            'form.phone_email_card_number' => 'Field is required',

        ]);


        $input = $this->form['phone_email_card_number'];
        if (str($input)->contains('@')) {
            $type = "email";
        } elseif (str($input)->contains('+')) {
            $type = "phone";
        }elseif (is_numeric($input) && strlen($input) < 10) {
            $type = "id";
        } 
         else {
            $type = "card";
        }

        try {
            switch ($type) {
                case "email":
                    $user = $this->userRepository->getUserByEmail($this->form['phone_email_card_number'],true);
                    break;

                case "phone":
                    $user = $this->userRepository->getUserByPhone($this->form['phone_email_card_number'],true);
                    break;
                case "id":
                    $user = $this->userRepository->getUserById($input,true);
                    break;
                case "card":
                    $user = $this->userRepository->getUserByCardNumber($this->form['phone_email_card_number'],true);
                    break;
            }
        } catch (\Throwable $th) {
            $this->sendError("Error", "Please enter card number, phone, or email.");
            return;
        }

        if (!$user) {
            $this->sendError("Error", "Please enter card number, phone, or email.");
            return;
        }


        $card_number = $this->cardRepository->getCardByUserId($user->id);

        $this->barcode = $card_number['barcode'] ?? null;


        $this->transactions = $this->cardRepository->getWalletTransactions($user);
        $this->balance = collect($this->transactions)->last()['balance'] ?? 0;
        $this->user = $user;
        $this->loyaltyTransactions = $this->cardRepository->getLoyaltyTransactions($user);
        $this->loyaltyBalance = $user->loyalty_balance ?? 0;
    }


    public function render()
    {

        return view('components.form.get-user');
    }
}
