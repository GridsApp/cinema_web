<?php

namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function createOrderFromCart($payment_attempt);
    public function getOrderByBarcode($barcode);
    public function getOrderSeatsByIds($order_id, $order_seat_id);
    public function getUserOrders($user_id);
    public function getOrderSeats($order_id, $grouped = false);
    public function getOrderItems($order_id, $grouped = false);
    public function getOrderTopups($order_id, $grouped = false);


}