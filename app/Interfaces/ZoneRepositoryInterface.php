<?php

namespace App\Interfaces;

interface ZoneRepositoryInterface 
{
    public function getZonesPrices($zone_ids);
}