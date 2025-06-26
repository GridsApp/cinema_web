<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    use HasFactory;

    public function coupon(){
        return $this->belongsTo(Coupon::class , 'coupon_id' , 'id');
    }

    public function seats() {
        return $this->hasMany(\App\Models\CartSeat::class);
    }

    public function coupons() {
        return $this->hasMany(\App\Models\CartCoupon::class);
    }

    public function imtiyaz() {
        return $this->hasMany(\App\Models\CartImtiyaz::class);
    }

    public function items() {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function topups() {
        return $this->hasMany(\App\Models\CartTopup::class);
    }
}
