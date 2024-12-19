<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieShow extends Model
{
    use HasFactory;

    protected $casts = [
        'system_id' => 'array', 
    ];


    public function movie(){
        return $this->belongsTo(Movie::class , 'movie_id' , 'id');
    }

    public function time(){
        return $this->belongsTo(Time::class , 'time_id' , 'id');
    }

    public function theater(){
        return $this->belongsTo(Theater::class , 'theater_id' , 'id');
    }
    public function screenType(){
        return $this->belongsTo(ScreenType::class , 'screen_type_id' , 'id');
    }

}

