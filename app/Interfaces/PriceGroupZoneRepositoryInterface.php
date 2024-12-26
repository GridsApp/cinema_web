<?php

namespace App\Interfaces;

interface PriceGroupZoneRepositoryInterface 
{
    // public function getPriceGroupZoneById($zone);
    public function getPriceByZonePerDate($zone_id , $date);
}