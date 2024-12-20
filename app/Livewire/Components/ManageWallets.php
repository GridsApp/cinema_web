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


    public function mount(){
        $this->form['card_number'] = "";

        $this->form['transaction_type'] = null;
        $this->form['amount'] = null;
        $this->form['description'] = null;


        $this->transactions = collect($this->transactions);
    }

    public function searchByCard(){

    
        $this->validate([
            'form.card_number' => 'required'
        ]);


        $user = $this->userRepository->getUserByCardNumber($this->form['card_number']);
        
   
        $this->transactions = $this->cardRepository->getWalletTransactions($user);
       
        $this->balance = collect($this->transactions)->last()['balance'] ?? 0;


        // dd($transactions);

    }

    public function submitForm(){
       

        $this->validate([
            'form.card_number' => 'required',

            'form.transaction_type' => 'required',
            'form.amount' => 'required',
            'form.description' => 'required',
            
        ]);

        $user = $this->userRepository->getUserByCardNumber($this->form['card_number']);
        

        if($this->form['transaction_type'] == 'topup'){
            $type = "in";
        }elseif($this->form['transaction_type'] == 'deduct'){
            $type = "out";
        }else{
            dd("someyhing wen wrony");
        }


        $this->cardRepository->createWalletTransaction($type, $this->form['amount'], $user, $this->form['description'], "CMS");
       

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
