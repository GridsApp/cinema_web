<?php

namespace App\Repositories;


use App\Interfaces\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
{

    public function checkCouponById($coupon_id){
     
        try {
            return Coupon::whereNull('deleted_at')->firstOrFail($coupon_id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
     
    }

}