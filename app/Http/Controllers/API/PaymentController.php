<?php

namespace App\Http\Controllers\API;

use App\Classes\OmnipayCallbackService;
use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OmniPayRepositoryInterface;

use App\Models\PaymentAttempt;
use App\Models\PaymentMethod;

use Illuminate\Support\Facades\DB;
use twa\cmsv2\Traits\APITrait;
use App\Repositories\PaymentGateways\Hyperpay;
use App\Repositories\PaymentGateways\Zaincash;

class PaymentController extends Controller
{
    use APITrait;

    private OmniPayRepositoryInterface $omniPayRepository;
    private CardRepositoryInterface $cardRepository;

    public function __construct(OmniPayRepositoryInterface $omniPayRepository,CardRepositoryInterface $cardRepository)
    {
        $this->omniPayRepository = $omniPayRepository;
        $this->cardRepository = $cardRepository;
    }

    public function list()
    {

        $user = request()->user;
        $user_type = request()->user_type;

        $location = request()->location;


        switch($location){

            case 'TOPUP':
                $ids = [1,7];
            break;

            case 'CHECKOUT':
                $ids = [3];
            break;

            default:

            $ids = [1,2,3,4,5,6,7];

            break;

        }

    
        try {
            $system_id = get_system_from_type($user_type);
        } catch (\Throwable $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }
       

// dd($user);
      $balance=  $this->cardRepository->getWalletBalance($user);
        

    //   dd($balance);

        $payment_methods = PaymentMethod::whereNull('deleted_at')->where('system_id',$system_id)
        ->whereIn('id' , $ids)
        ->get()->map(function ($payment_method) use($balance) {
            // dd($balance);npm
            return [
                'id' => $payment_method->id,
                'label' => $payment_method->label,
                'key' => $payment_method->key,


                // 'system' => $payment_method->sytem_id,
                'sublabel' => $payment_method->key == "WP"
                ? 'Current Balance: ' . $balance
                : '',
                'image' => get_image($payment_method->image),

            ];
        });

        return $this->responseData($payment_methods);
    }



    public function initialize($payment_attempt_id)
    {


        $request_token = request()->input('token');



        $payment_attempt = PaymentAttempt::find($payment_attempt_id);

        if (!$payment_attempt) {
            return abort(404);
        }

        $user_id = $payment_attempt->user_id ? $payment_attempt->user_id : ($payment_attempt->pos_user_id ?? 0);

        $token = md5($payment_attempt->id . '' . $user_id . '' . $payment_attempt->payment_method_id . '' . round($payment_attempt->amount, 0));

        if ($token !== $request_token) {
            return abort(404);
        }

    

        $return_url = $this->omniPayRepository->createPayment($payment_attempt);

        return redirect($return_url);
    }

    public function omniResponse($payment_attempt_id){


        $payment_attempt = PaymentAttempt::find($payment_attempt_id);

        // dd($payment_attempt);
        if(!$payment_attempt){
            return redirect()->route('payment.response.status', [
                'type' => 'fail',
                'title' => 'Payment Failure',
                'message' => 'Payment has been failed to be completed'
            ]);
        }


        $check_payment = $this->omniPayRepository->checkPayment($payment_attempt);

        if(!$check_payment){
            return redirect()->route('payment.response.status', [
                'type' => 'fail',
                'title' => 'Payment Failure',
                'message' => 'Payment has been failed to be completed'
            ]);
        }
    
        return $this->callback($payment_attempt);
    }


    public function callback($payment_attempt_id)
    {



        try {


            DB::beginTransaction();


            if(is_numeric($payment_attempt_id)){
                $payment_attempt = PaymentAttempt::where('id', $payment_attempt_id)->first(); 
            }else{
                $payment_attempt = $payment_attempt_id;
            }

            if (!$payment_attempt || ($payment_attempt && !$payment_attempt->converted_at)) {
                return redirect()->route('payment.response.status', [
                    'type' => 'fail',
                    'title' => 'Payment Failure',
                    'message' => 'Payment has been failed to be completed'
                ]);
            }

            $payment_attempt->completed_at = now();

            $service = app(\App\Services\OmnipayCallbackService::class);
            $callback = $service->callback($payment_attempt);


            if (!$callback) {

                $payment_attempt->save();

                return redirect()->route('payment.response.status', [
                    'type' => 'error',

                    'title' => 'Payment Successfull but something went wrong',
                    'message' => 'Payment was successfull but something went wrong after it. Please contact our customer support'
                ]);
            }


            $payment_attempt->converted_at = now();
            $payment_attempt->save();

            DB::commit();

            return redirect()->route('payment.response.status', [
                'type' => 'success',
                'id' => $callback["order_id"],
                'title' => 'Payment Successfull',
                'message' => 'Payment has been completed successfully'
            ]);
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()->route('payment.response.status', [
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
