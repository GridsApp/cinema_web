<?php

namespace App\Repositories;

use App\Interfaces\ZoneRepositoryInterface;
use App\Models\PriceGroupZone;

class ZoneRepository implements ZoneRepositoryInterface
{

    public function getZonesPrices($zone_ids){

      $zones = PriceGroupZone::whereNull('deleted_at')->whereIn('id' , $zone_ids)->get();


      return $zones;
    }
   
}
