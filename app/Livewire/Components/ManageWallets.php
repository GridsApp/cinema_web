<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Livewire\Attributes\Url;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class ManageWallets extends Component
{

    use ToastTrait;


    #[Url]
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

       

        if(!isset($this->form['card_number'])){
            $this->form['card_number'] = '';
        }

        $this->form['transaction_type'] = null;
        $this->form['amount'] = null;
        $this->form['description'] = null;


        $this->transactions = collect($this->transactions);
    }

    public function searchByCard()
    {



        // dd(cms_check_permission('view-transactions'));
       
        if (!cms_check_permission('view-transactions')) {
            $this->sendError("Permission Denied", "You do not have permission to view transactions.");
            return;
        }

        $this->validate([
            'form.card_number' => 'required'
        ], ['form.card_number' => 'Card number is required']);


        // dd("sd");

        try {
            $user = $this->userRepository->getUserByCardNumber($this->form['card_number']);
        } catch (\Throwable $th) {
            $this->form['card_number'] = null;
            $this->sendError("Error", "User Card Not Found");
            return;
        }

        // try {
        $this->transactions = $this->cardRepository->getWalletTransactions($user);
        // } catch (\Throwable $th) {
        //     $this->sendError("Error", "Failed to retrieve wallet transactions for the user.");
        //     return;
        // }

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

            $this->cardRepository->createWalletTransaction($type, $this->form['amount'], $user, $this->form['description'], null, null, $operator_id, "twa\cmsv2\Models\CmsUser");
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

    public function handleClear(){
        $this->form['card_number'] = null;
    }

    public function render()
    {

        if(isset($this->form['card_number']) && !empty($this->form['card_number'])){
            $this->searchByCard();
        }

        return view('components.form.manage-wallets');
    }
}
