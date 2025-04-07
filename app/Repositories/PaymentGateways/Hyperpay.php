<?php

namespace App\Repositories\PaymentGateways;

use Illuminate\Support\Facades\Http;
use App\Classes\PaymentData;
use App\Models\PaymentAttemptLog;

class Hyperpay
{
    public $data;
    public $provider_key;


    public function __construct($data , $provider_key)
    {

        $this->provider_key = $provider_key;
        $this->data = $data;
    }

    public function createPayment($attempt , PaymentData $payment_data){
      

        $merchantRefID = (int) $payment_data->reference_prefix.$payment_data->reference;

        $query = "entityId=" .$this->data['entity_id'].
        "&amount=" . round($payment_data->amount,2).
        "&currency=" .$payment_data->currency .
        "&paymentType=" .$this->data["payment_type"].
        "&integrity=" .true.
        "&merchantTransactionId=". $merchantRefID;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->data['token'],
        ])->post($this->data['url'].'/checkouts?'.$query, []);

  
        if ($response->status() != '200' && $response->status() != '201') {
            create_payment_log("API REQUEST FAILURE" , $response->json() , $attempt->id);
            dd("API REQUEST FAILURE");
        }
     
        $response = json_decode($response->body());

        
        if (!isset($response->result->code) || (isset($response->result->code) && $response->result->code != "000.200.100")) {
        
            create_payment_log("API INVALID RESPONSE" , $response , $attempt->id);
            dd("API INVALID RESPONSE");
        }

        $log = create_payment_log("API REQUEST CREATED" , $response , $attempt->id , "init");
   
        $link = route('hyperpay-redirect-link' , [
            'provider_key' => $this->provider_key,
            'attempt_id' => $attempt->id,
            'token' => md5($response->id.$attempt->id.$this->provider_key.$response->integrity),
            'log_id' => $log->id

            
        ]);
       
        // dd($link);
        return [
            "completed" => false ,
            'redirect' => [
                'link' => $link,
            ],
        ];

    }



    public function checkPayment($attempt , $parameters){

      

        $gateway_log = PaymentAttemptLog::where('payment_attempt_id' , $attempt->id)->where('type' , 'init')->orderBy('id' , 'DESC')->first();
        $gateway_init = $gateway_log->payload;
  
        if(!isset($gateway_init["id"])){
            create_payment_log("MISSING QUERY SOME PARAMS" , $parameters , $attempt->id);

            return response(["title" => "Unexpected error!"  , "message" => "An unexpected error occured" ] , 400);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->data['token'],
        ])->get($this->data['url'].'/checkouts/'.$gateway_init["id"]."/payment?entityId=".$this->data["entity_id"]);



        if ($response->status() != '200' && $response->status() != '201') {

            create_payment_log("PAYMENT FAILURE (FINAL RESPONSE)" , $response->json() , $attempt->id);

            return response(["title" => "Payment was not successfull"  , "message" => "Payment was not successfull" ] , 400);
        }

        $response = json_decode($response->body());

        if(!isset($response->result->code) || (isset($response->result->code) && preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $response->result->code) != 1)){
        
            create_payment_log("PAYMENT FAILURE (FINAL RESPONSE)" , $response , $attempt->id);

            return response(["title" => "Payment was not successfull"  , "message" => "Payment was not successfull" ] , 400);
        }

        create_payment_log("PAID SUCCESSFULLY (FINAL RESPONSE)" , $response , $attempt->id , 'response');

        $attempt->converted_at = now();
        $attempt->payment_reference = $response->resultDetails->AuthCode ?? "";
        $attempt->save();

        return response(["row_id" => $attempt->row_id  , "row_model" => $attempt->row_model , 'payment_ref' => $attempt->payment_reference ] , 200);
    }
}
