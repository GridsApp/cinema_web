<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAttemptLog extends Model
{
    protected $casts = [
        'payload' => 'array'
    ];
}
