<?php

namespace App\Interfaces;

interface CardRepositoryInterface
{
    public function createWalletTransaction($type, $amount, $user, $description, $reference = null, $gateway_reference = null);
    public function createLoyaltyTransaction($type, $amount, $user, $description, $reference = null);
    public function createCard($user, $barcode = null, $type = 'digital');
    public function getLoyaltyBalance($user);
    public function getWalletBalance($user);
    public function getActiveCard($user);
    public function getCardByBarcode($barcode);
    public function getLoyaltyTransactions($user);
    public function getWalletTransactions($user);
    public function generateBarcode();
    // public function getActiveCardInfo($user);
    // public function getCardInfo($user);
}
