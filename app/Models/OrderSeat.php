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

    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id')->whereNull('deleted_at');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->whereNull('deleted_at');
    }
    
  
    
}
