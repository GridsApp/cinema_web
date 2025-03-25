<?php

namespace App\Interfaces;

interface CartRepositoryInterface 
{
    public function checkCart($cart_id , $user_id , $user_type);
    public function getCartById($cart_id);
    public function createCart($user_id, $user_type , $system_id);
    public function expireCart($cart_id);
    public function addSeatToCart($cart_id, $seat,$movie_show_id , $zone_id);
    public function removeSeatFromCart($cart_id, $seat,$movie_show_id);
    public function addItemToCart($cart_id , $item_id);
    public function removeItemFromCart($cart_id , $item_id);
    public function addTopupToCart($cart_id,$amount);
    public function removeTopupFromCart($cart_id );
    public function addCardNumberToCart($cart_id, $card_number);
    public function removeCardNumberFromCart($cart_id);
    public function getReservedSeats($movie_show_id);
    public function getCartSeats($cart_id , $grouped = false);
    public function getCartItems($cart_id,$grouped = false);
    public function getCartTopups($cart_id, $grouped = false);
    public function getCartCoupons($cart_id);
    public function getCartCouponsIds($cart_id);
    public function addCouponToCart($cart_id,$coupon);
    public function removeCouponFromCart($cart_id , $coupon_code);
    public function checkCouponInCart($cart_id , $coupon_id);


    public function addImtiyazToCart($cart_id, $phone);
    public function removeImtiyazFromCart($cart_id , $phone);

    public function getCartDetails($cart);    

    public function getImtiyazCountFromCart($cart_id);
    public function getCouponCountFromCart($cart_id);
    public function getImtiyazByCartId($cart_id);

}