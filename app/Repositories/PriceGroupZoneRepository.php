<?php

namespace App\Repositories;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\PriceGroupZoneRepositoryInterface;
use App\Models\Branch;
use App\Models\PriceGroup;
use App\Models\PriceGroupZone;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PriceGroupZoneRepository implements PriceGroupZoneRepositoryInterface
{


    public function getPriceByZonePerDate($zone_id , $date , $time = null){
        try {

            $period = get_setting('time_period') <= $time ? 'before' : 'after';

            $price_group_zone =  PriceGroupZone::whereNull('deleted_at')->first();

            dd($price_group_zone);

            $price_settings = $price_group_zone->price_settings;

            $day = strtolower(now()->parse($date)->format('l'));

            $condition = collect($price_settings['conditions'])
            ->where('day' , $day)
            ->where('period' , $period)
            ->first();

            if($condition){
                return $condition['price'];
            }

            return $price_settings['defaultPrice'];

        } catch (ModelNotFoundException $e) {
              throw new ModelNotFoundException($e->getMessage());
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }




}