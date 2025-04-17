<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderSeat extends Model
{
    use HasFactory;


    public function movieShow()
    {
        return $this->belongsTo(MovieShow::class, 'movie_show_id')->whereNull('deleted_at');
    }
    

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id')->whereNull('deleted_at');
    }
    
    public function theater()
    {
        return $this->belongsTo(Theater::class, 'theater_id')->whereNull('deleted_at');
    }
    public function screenType()
    {
        return $this->belongsTo(ScreenType::class, 'screen_type_id');
    }

    public function zone()
    {
        return $this->belongsTo(PriceGroupZone::class, 'zone_id')->whereNull('deleted_at');
    }
   
    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id')->whereNull('deleted_at');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->whereNull('deleted_at');
    }

    public function refundedCashier()
    {
        return $this->belongsTo(PosUser::class, 'refunded_cashier_id')->whereNull('deleted_at');
    }
    public function refundedManager()
    {
        return $this->belongsTo(PosUser::class, 'refunded_manager_id')->whereNull('deleted_at');
    }
    
  
    
    
    
}
