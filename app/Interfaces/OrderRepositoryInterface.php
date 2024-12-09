<?php

namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function createOrderFromCart($payment_attempt);
    public function getOrderByBarcode($barcode);
    // public function refundOrderSeats($order_id, $order_seat_id, $branch_id, $user_id, $user_type, $field);
    public function getOrderSeats($order_id, $order_seat_id);
    


}