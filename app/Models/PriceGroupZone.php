<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceGroupZone extends Model
{
    use HasFactory;


    protected $casts = [
        'price_settings' => 'array'
    ];

    public function priceGroup(){
        return $this->belongsTo(PriceGroup::class , 'price_group_id' , 'id');
    }


   
}
