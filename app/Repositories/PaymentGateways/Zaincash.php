<?php

namespace App\Repositories\PaymentGateways;

use App\Models\PaymentAttemptLog;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Zaincash
{

    public $data;
    public $provider_key;


    public function __construct($data , $provider_key)
    {

        $this->provider_key = $provider_key;
        $this->data = $data;


    }

    public function createPayment($attempt , $payment_data){



        $data = [
                'amount'  => $payment_data->amount,
                'serviceType'  => isset($payment_data->phone) ? $payment_data->phone : 'NULL',
                'msisdn'  => $this->data["msisdn"], // Your wallet phone number
                'orderId'  => $payment_data->reference_prefix.$payment_data->reference,
                // 'redirectUrl'  => env('APP_URL')."/payment/redirect?omnipay_ref=".$attempt->id,
                'redirectUrl' => route('payment.response' , ['payment_attempt_id' => $attempt->id]),
                'iat'  => time(),
                'exp'  => time()+60*60*4
        ];




        $newtoken = JWT::encode($data, $this->data["merchantSecret"] ,'HS256');

        $data_to_post = array();
        $data_to_post['token'] = urlencode($newtoken);
        $data_to_post['merchantId'] = $this->data["merchantId"];
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data_to_post),
            ),
        );
        $context = stream_context_create($options);
        $response = file_get_contents($this->data["gatewayUrl"]."/init", false, $context);




        try{
            $array = json_decode($response, true);

            if(!isset($array['id'])){
                create_payment_log("INVALID SESSION RESPONSE" , $array , $attempt->id);
                dd($attempt->message);
            }

            $transaction_id = $array['id'];

            create_payment_log("SESSION CREATED" , $array , $attempt->id,"init");

            $link = $this->data["gatewayUrl"]."/pay?id=".$transaction_id;

            return [
                "completed" => false ,
                "redirect" => [
                    "link" => $link
                ]
            ];

        }catch(\Throwable $th){

            create_payment_log("API REQUEST FAILURE" , $array , $attempt->id);

            dd($attempt->message);
        }


    }

    public function checkPayment($attempt , $parameters){

        // $token =  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdGF0dXMiOiJmYWlsZWQiLCJvcmRlcmlkIjoiMjAxMDM1ODgiLCJpZCI6IjY2ODI5Y2JhM2MzZDdmMjQ2ZTc3NmE2ZiJ9.bMoEj8Rxlsf27I9WU3Mj9IZXjeTHacK8egpLJ6p_9xE";
        if(isset($parameters["token"])){
            $result= JWT::decode($parameters["token"], new Key($this->data["merchantSecret"], 'HS256'));
            $result= (array) $result;


            if(isset($result['status']) && $result['status'] == 'success'){

                create_payment_log("PAID SUCCESSFULLY" , $result , $attempt->id,'response');

                $attempt->converted_at = now();
                $attempt->payment_reference = $result["operationid"] ?? "?";
                $attempt->save();


                return response(["row_id" => $attempt->row_id  , "row_model" => $attempt->row_model , 'payment_ref' => $attempt->payment_reference ] , 200);
            }
        }

        $gateway_log = PaymentAttemptLog::where('payment_attempt_id' , $attempt->id)->where('type' , 'init')->orderBy('id' , 'DESC')->first();
        $gateway_init = $gateway_log->payload;

        if(!isset($gateway_init["id"])){
            create_payment_log("MISSING QUERY SOME PARAMS" , $parameters , $attempt->id);
            return response(["title" => "Unexpected error!"  , "message" => "An unexpected error occured" ] , 400);
        }

        $data = [
            'id'  => $gateway_init["id"],
            'msisdn'  => $this->data["msisdn"], // Your wallet phone number
            'iat'  => time(),
            'exp'  => time()+60*60*4
        ];

        $newtoken = JWT::encode($data, $this->data["merchantSecret"] ,'HS256');

        $data_to_post = array();
        $data_to_post['token'] = urlencode($newtoken);
        $data_to_post['merchantId'] = $this->data["merchantId"];
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data_to_post),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($this->data["gatewayUrl"].'/get', false, $context);

        $result = json_decode($response, true);


        if(!isset($result['status']) || (isset($result['status']) && $result['status'] != 'success' && $result['status'] != 'completed')){

            create_payment_log("PAYMENT FAILURE (FINAL RESPONSE)" , $result , $attempt->id);

            return response(["title" => "Payment was not successfull"  , "message" => "Payment was not successfull" ] , 400);
        }

        create_payment_log("PAID SUCCESSFULLY" , $result , $attempt->id  , 'response');

        $attempt->converted_at = now();
        $attempt->payment_reference = $result["operationid"] ?? "?";
        $attempt->save();

        return response(["row_id" => $attempt->row_id  , "row_model" => $attempt->row_model , 'payment_ref' => $attempt->payment_reference] , 200);

    }

}
