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


    public function getPriceByZonePerDate($zone_id,$movie_id,$date,$time = null){
        try {



            $period = $time < get_setting('time_period') ? 'before' : 'after';

            if(!is_numeric($zone_id)){
                $price_group_zone =  $zone_id;
            }else{
                $price_group_zone =  PriceGroupZone::where('id', $zone_id)->whereNull('deleted_at')->firstOrFail();
            }

            $price_settings = $price_group_zone->price_settings;

            $day = strtolower(now()->parse($date)->format('l'));


            $movie_condition = collect($price_settings['moviePriceConditions']??[])
                ->where('day' , $day)
                ->where('period' , $period)
                ->where('movie_id' , $movie_id)
                ->first();

            if($movie_condition){
                return $movie_condition['price'];
            }

            $movie_price = collect($price_settings['moviePrices'] ?? [])
                ->where('movie_id' , $movie_id)
                ->first();

            if($movie_price){
                return $movie_price['price'];
            }

            $condition = collect($price_settings['conditions'] ?? [])
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
