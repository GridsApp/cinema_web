<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAttempt extends Model
{
    use HasFactory;


    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class , 'payment_method_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

}
