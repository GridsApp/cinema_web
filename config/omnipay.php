<?php

return [

 
    'OP-ZC-TEST' => [

        'data' => [
            "gatewayUrl" => "https://test.zaincash.iq/transaction",
            "merchantId" => "5ffacf6612b5777c6d44266f",
            "merchantSecret" => '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS',
            "msisdn" => "9647835077893"
        ]
    ],
    'OP-ZC' => [
   
        'data' => [
            "gatewayUrl" => "https://api.zaincash.iq/transaction",
            "merchantId" => "59de0513bb20d6d227dd4b8d",
            "merchantSecret" => '$2y$10$J9bCanqYALMaiNqZfVhB/ulaDHnnpND8i0M4.qxew93qm4ym5o8Ve',
            "msisdn" => "9647808030002"
        ]
    ],
 

    'OP-HY-TEST' => [

        'authorization_type' => 'redirect',
        'currencies' => ['IQD'],
        'data' => [
            'entity_id' => "8a8294174d0595bb014d05d829cb01cd",
            'token' =>"OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA==",
            'url' =>  "https://eu-test.oppwa.com/v1", 
            'domain' =>  "https://eu-test.oppwa.com", 
            'brands' => ["VISA", "MASTER"],
            'payment_type' => 'DB',
            'country_code' => 'IQ'
        ]
    ],

    'OP-HY' => [

        'authorization_type' => 'redirect',
        'currencies' => ['IQD'],
        'data' => [
            'entity_id' => "8ac9a4c786e49e2601870877acd7052e",
            'token' =>"OGFjOWE0Yzc4NmU0OWUyNjAxODcwODc2ZDlhYjA1MjV8SFFkcXRFNmZrNQ==",
            'domain' => 'https://eu-prod.oppwa.com',
            'url' => 'https://eu-prod.oppwa.com/v1',
            'brands' => ["VISA", "MASTER"],
            'payment_type' => 'DB',
            'country_code' => 'IQ'
        ]
    ],







];
