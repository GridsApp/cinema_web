<?php

namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function createOrderFromCart($payment_attempt);
    public function getUserOrders($user_id);
    public function getOrderByBarcode($barcode);
    public function getOrderById($order_id);
    public function getOrderSeats($order_id, $grouped = false);
    public function getOrderSeatsByIds($order_id, $order_seat_id);
    public function getOrderItems($order_id, $grouped = false);
    public function getOrderTopups($order_id, $grouped = false);
    public function getPaymentMethodById($payment_method_id);
    public function getPosuserLastOrder($pos_user_id);
    public function generateLongId($id);

}