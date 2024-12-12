<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order  extends Model
{
    use HasFactory;


    public function system()
    {
        return $this->belongsTo(System::class, 'system_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posUser()
    {
        return $this->belongsTo(PosUser::class, 'pos_user_id');
    }


    public function refundedCashier()
    {
        return $this->belongsTo(PosUser::class, 'refunded_cashier_id', 'id');
    }


    public function seats()
    {
        return $this->hasMany(OrderSeat::class, 'order_id')->whereNull('deleted_at');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id')->whereNull('deleted_at');
    }

    public function topups()
    {
        return $this->hasMany(OrderTopup::class, 'order_id')->whereNull('deleted_at');
    }

}
