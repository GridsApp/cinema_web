<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CartSeat extends Model
{
    use HasFactory;
    public function zone(){
        return $this->belongsTo(PriceGroupZone::class , 'zone_id' , 'id');
    }

    public function movieShow()
    {
        return $this->belongsTo(MovieShow::class, 'movie_show_id', 'id')->whereNull('deleted_at');
    }
    
    
}
