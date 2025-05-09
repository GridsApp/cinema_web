<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class UncompletedPayments extends Component
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


    public function mount() {}

    public function get()
    {
        $uncompleted = DB::table('payment_attempt_logs')
            ->join('payment_attempts',  'payment_attempt_logs.payment_attempt_id' , 'payment_attempts.id' )
            ->join('payment_methods', 'payment_attempts.payment_method_id', 'payment_methods.id')
            ->join('users', 'payment_attempts.user_id', 'users.id')
            ->join('user_cards',function($join){
                $join->on('user_cards.user_id' , 'payment_attempts.user_id')
                ->whereNull('user_cards.disabled_at');
            })
          

            ->select('payment_attempts.id', 'user_cards.barcode'  ,'payment_attempts.user_id', 'payment_attempts.amount', 'payment_attempts.payment_reference','payment_attempt_logs.message')
          
            ->where('payment_attempt_logs.type', 'response')
            ->where('payment_attempt_logs.message', 'LIKE' , '%(FINAL RESPONSE)%')
            ->whereNotNull('payment_attempts.converted_at')
            ->whereNull('payment_attempts.completed_at')
            ->whereNotNull('payment_attempts.user_id')
            ->get();

            dd($uncompleted);
    }


    public function render()
    {
        $this->get();

        return view('components.form.uncompleted-payments');
    }
}
