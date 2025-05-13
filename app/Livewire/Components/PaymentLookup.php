<?php

namespace App\Livewire\Components;

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

    public function render()
    {
        return view('livewire.components.payment-lookup');
    }

    public function searchPaymentReference(){


        $payment = DB::table('order_topups')
            ->select('order_topups.label as topup_desc' , 'order_topups.price' , 'payment_methods.label as payment_method' , 'users.name as user')
            ->join('orders', 'orders.id', '=', 'order_topups.order_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_reference', $this->form['payment_ref'])
            ->first();

       if(!$payment){
           $this->sendError("Payment not Found", "Payment not Found");
           return;
       }

        $this->payment = $payment;

    }

    public function handleClear(){
        $this->payment = null;
        $this->form['payment_ref'] = null;
    }
}
