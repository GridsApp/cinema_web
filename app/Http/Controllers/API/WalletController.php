<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Models\PaymentAttempt;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class WalletController extends Controller
{

    use APITrait;


    private CardRepositoryInterface $cardRepository;

    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function test(){

        $user = request()->user;

        $this->cardRepository->createLoyaltyTransaction("in", 1000, $user, "nourhane", $reference = null);
    }



    public function recharge(){

        $form_data = clean_request([]);

        $minimum_recharge_amount = 10000;
        $maximum_recharge_amount = 50000;


        $user_id = request()->user->id;

        if ($user_id == 7612) {
            $minimum_recharge_amount = 1000;
        }
        
        $validator = Validator::make($form_data, [
            'amount' => 'required|numeric|min:'.$minimum_recharge_amount.'|max:'.$maximum_recharge_amount,
            'payment_method_id' => 'required'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        // Payment Record 7612

   
    
    
        $payment_attempt = new PaymentAttempt();
        $payment_attempt->user_id = $user_id;
        $payment_attempt->amount = $form_data['amount'];
        $payment_attempt->payment_method_id = $form_data['payment_method_id'];
        // $payment_attempt->action = "(new \App\Http\Controllers\API\WalletController)->rechargeCallback()";


        
        $payment_attempt->action = "RECHARGE_WALLET";
        // $payment_attempt->row_table = "user_wallet_transactions";
        // $payment_attempt->row_id = "payment-attempts";


        $payment_attempt->save();
    
    
        $token = md5($payment_attempt->id.''.$user_id.''.$payment_attempt->payment_method_id.''.round($payment_attempt->amount,0));

        return $this->responseData([
            'redirect' => route("payment.initialize" , [
                'payment_attempt_id' => $payment_attempt->id,
                'token' => $token
            ])
        ]);
 
    }


    public function rechargeCallback($payment_attempt_id){
        

        return false;
        // $payment_attempt = PaymentAttempt::whereNull('deleted_at')->where('id' , $payment_attempt_id)->first();

       
        // if(!$payment_attempt){
        //     return false;
        // }

        // $user = $payment_attempt->user;

        // $this->cardRepository->createWalletTransaction("in" , $payment_attempt->amount , $user, "Recharge amount of reference " . $payment_attempt->id , $payment_attempt->id , $payment_attempt->gateway_reference ?? null);
        
        return true;

    }
}
