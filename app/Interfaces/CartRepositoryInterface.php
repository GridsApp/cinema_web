<?php

namespace App\Interfaces;

interface CartRepositoryInterface 
{
   
    public function createCart($user_id, $user_type , $system_id);
    public function checkCart($cart_id , $user_id , $user_type);
    public function expireCart($cart_id);
    public function addItemToCart($cart_id , $item_id);
    public function removeItemFromCart($cart_id , $item_id);
    public function addSeatToCart($cart_id, $seat,$movie_show_id , $zone_id);
    public function removeSeatFromCart($cart_id, $seat,$movie_show_id);
    public function getCartSeats($cart_id , $grouped = false);
    public function getCartItems($cart_id,$grouped = false);
    public function addTopupToCart($cart_id,$amount);
    public function addCouponToCart($cart_id,$coupon_id);
    public function removeCouponFromCart($cart_id);
    public function addCardNumberTocart($cart_id, $card_number);
    public function removeCardNumberFromCart($cart_id);
    public function removeTopupFromCart($cart_id );
    public function getCartTopups($cart_id, $grouped = false);
    public function getCartById($cart_id);
    public function getCouponByCode($code);
    public function getCartDetails($cart , $coupon = null);
     public function getSystemById($system_id);
     public function getReservedSeats($movie_show_id);

    
    // public function getCardByBarcode($card_number);


}