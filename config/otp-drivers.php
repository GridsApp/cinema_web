<?php

return [


    // "sms"=>[
    //     'label'=>'Send OTP by SMS',
    //     'driver'=>'sms',
    //     'field'=>'phone_verified_at',
    // ],


    // "wp"=>[
    //     'label'=>'Send OTP by Whatsapp',
    //     'driver'=>'wp',
    //     'field'=>'phone_verified_at'
    // ],

    "mail"=>[
        'label'=>'Send OTP by Email',
        'driver'=>'mail',
        'field'=>'email_verified_at'
    ]

    ];