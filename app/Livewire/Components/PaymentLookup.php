<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PaymentAttempt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class PaymentLookup extends Component
{
    use ToastTrait;

    public $form = [
        'payment_ref' => null
    ];

    public $payment;
    public $transaction;
    public $transaction_logs = [];



    private OrderRepositoryInterface $orderepository;


    public function __construct()
    {

        $this->orderepository = app(OrderRepositoryInterface::class);
    }

    public function render()
    {
        return view('livewire.components.payment-lookup');
    }



    public function searchPaymentReference(){


        $this->payment = DB::table('order_topups')
            ->select('order_topups.label as topup_desc' , 'orders.user_id' , 'order_topups.price' , 'payment_methods.label as payment_method' , 'users.name as user' , 'orders.created_at')
            ->join('orders', 'orders.id', '=', 'order_topups.order_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_reference', $this->form['payment_ref'])
            ->first();


        $this->transaction = DB::table('payment_attempts')
            ->select('payment_attempts.id' , 'payment_attempts.amount' , 'payment_methods.label as payment_method' , 'users.name as user' ,  'payment_attempts.user_id'  ,'payment_attempts.created_at')
            ->where('payment_reference', $this->form['payment_ref'])
            ->join('payment_methods', 'payment_methods.id', '=', 'payment_attempts.payment_method_id')

            ->leftJoin('users', 'users.id', '=', 'payment_attempts.user_id')
            ->first();


        if(isset($this->transaction->id)) {
            $this->transaction_logs = DB::table('payment_attempt_logs')
                ->where('payment_attempt_id', $this->transaction->id)
                ->orderBy('id', 'ASC')
                ->get();
        }


       if(is_null($this->payment) && is_null($this->transaction) && count($this->transaction_logs) == 0) {
          return  $this->sendError("Payment not Found", "Payment not Found");
       }



    }

    public function treatPayment($id)
    {

        $attempt =  PaymentAttempt::find($id);

        if (!$attempt) {
            $this->sendError("Error", "Unable to treat");
            return;
        }

        try {
            DB::beginTransaction();

            $attempt->completed_at = now();
            $attempt->save();

            $this->orderepository->createOrderFromCart($attempt, null, true);

            DB::commit();
        } catch (\Throwable $th) {



            DB::rollBack();

            $this->sendError("Error", $th->getMessage());

            return;
        }
        $this->dispatch('payment-treated');

        $this->sendSuccess("Success", "Payment Treat");
    }



    public function handleClear(){
        $this->payment = null;
        $this->form['payment_ref'] = null;
    }
}
