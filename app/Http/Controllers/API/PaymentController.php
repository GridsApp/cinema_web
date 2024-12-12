<?php

namespace App\Http\Controllers\API;

use App\Classes\OmnipayCallbackService;
use App\Http\Controllers\Controller;

use App\Interfaces\OmniPayRepositoryInterface;

use App\Models\PaymentAttempt;
use App\Models\PaymentMethod;
use App\Traits\APITrait;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{


    use APITrait;


    private OmniPayRepositoryInterface $omniPayRepository;
    
    public function __construct(OmniPayRepositoryInterface $omniPayRepository)
    {
        $this->omniPayRepository = $omniPayRepository;
    }

    public function list(){
        $payment_methods= PaymentMethod::whereNull('deleted_at')->get()->map(function($payment_method){
            return [
                'id' => $payment_method->id,
                'label' => $payment_method->label,
                'sublabel' => $payment_method->key=="WP" ? 'Current Balance : 46,000':'',
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


    public function callback($payment_attempt_id)
    {

        try {
        

        DB::beginTransaction();


        $payment_attempt = PaymentAttempt::where('id', $payment_attempt_id)->whereNull('converted_at')->first();

        if (!$payment_attempt) {
            return redirect()->route('payment.response', [
                'type' => 'fail',
                'title' => 'Payment already completed',
                'message' => 'Payment was already completed'
            ]);
        }


        $check = $this->omniPayRepository->checkPayment($payment_attempt);

        if (!$check) {
            return redirect()->route('payment.response', [
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

            return redirect()->route('payment.response', [
                'type' => 'error',
                'title' => 'Payment Successfull but something went wrong',
                'message' => 'Payment was successfull but something went wrong after it. Please contact our customer support'
            ]);
        }


        $payment_attempt->converted_at = now();
        $payment_attempt->save();

        DB::commit();

        return redirect()->route('payment.response', [
            'type' => 'success',
            'title' => 'Payment Successfull',
            'message' => 'Payment has been completed successfully'
        ]);

    
        } catch (\Throwable $th) {
            
            DB::rollBack();

            return redirect()->route('payment.response', [
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
