<?php

namespace App\Repositories;


use App\Interfaces\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Coupon;
use Exception;

class CouponRepository implements CouponRepositoryInterface
{

    public function checkCouponById($coupon_id){
     
        try {
            return Coupon::whereNull('deleted_at')->where('id' , $coupon_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
     
    }
    public function getCouponsByIds($coupon_ids){
     
        try {
            
            return Coupon::query()
            ->whereNull('deleted_at')
            ->whereIn('id' , $coupon_ids)
            ->get();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
     
    }


    public function getCouponByCode($code)
    {
        try {
            $coupon = Coupon::where('code', $code)
                ->where('expires_at', '>', now())
                ->whereNull('used_at')
                ->whereNull('deleted_at')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Coupon with Code {$code} not found .");
        }

        return $coupon;
    }

}