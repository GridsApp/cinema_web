<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;

class ManageWallets extends Component
{

    use ToastTrait;

    public $form = [];
    public $transactions = [];
    public $balance = 0;


    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->cardRepository = app(CardRepositoryInterface::class);;
        $this->userRepository = app(UserRepositoryInterface::class);
    }


    public function mount()
    {
        $this->form['card_number'] = null;

        $this->form['transaction_type'] = null;
        $this->form['amount'] = null;
        $this->form['description'] = null;


        $this->transactions = collect($this->transactions);
    }

    public function searchByCard()
    {

        

        $this->validate([
            'form.card_number' => 'required'
        ] , ['form.card_number' =>'Card number is required']);


        // dd("sd");
        


        try {
            $user = $this->userRepository->getUserByCardNumber($this->form['card_number']);
        } catch (\Throwable $th) {

            $this->sendError("Error", "User Card Not Found");
            return;
        }

        try {
            $this->transactions = $this->cardRepository->getWalletTransactions($user);
        } catch (\Throwable $th) {
            $this->sendError("Error", "Failed to retrieve wallet transactions for the user.");
            return;
        }

        $this->balance = collect($this->transactions)->last()['balance'] ?? 0;
    }

    public function submitForm()
    {
        $cms_user = session('cms_user');

        // dd($cms_user->id);
        $this->validate([
            'form.card_number' => 'required',
            'form.transaction_type' => 'required',
            'form.amount' => 'required',
            'form.description' => 'required',
        ], [
             'form.card_number' => 'Card number is required',
            'form.transaction_type' => 'Transaction Type is required',
            'form.amount' => 'Amount is required',
            'form.description' => 'Description is required',
        ]);

        try {
            $user = $this->userRepository->getUserByCardNumber($this->form['card_number']);
        } catch (\Throwable $th) {
            $this->sendError("Error", "User Card Not Found");
            return;
        }


        if ($this->form['transaction_type'] == 'topup') {
            $type = "in";
        } elseif ($this->form['transaction_type'] == 'deduct') {
            $type = "out";
        } else {
            $this->sendError("Error", "Invalid transaction type.");
            return;
        }

        try {


        


            $operator_id = $cms_user->id;
            // dd($operator_id);

            $this->cardRepository->createWalletTransaction($type, $this->form['amount'], $user, $this->form['description'], "CMS", null , $operator_id , "twa\cmsv2\Models");
            $this->sendSuccess("Success", "Transaction created successfully.");
        } catch (\Throwable $th) {
            $this->sendError("Error", "Failed to create the transaction. Please try again later.");
        }



        $this->form['transaction_type'] = null;
        $this->form['amount'] = null;
        $this->form['description'] = null;

        $this->render();

        $this->searchByCard();
    }


    public function render()
    {





        return view('components.form.manage-wallets');
    }
}
