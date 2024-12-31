<?php

namespace App\Interfaces;

interface CouponRepositoryInterface 
{
   
    public function checkCouponById($coupon_id);
    public function getCouponsByIds($coupon_ids);
    public function getCouponByCode($code);

}