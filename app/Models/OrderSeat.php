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
    
  
    
}
