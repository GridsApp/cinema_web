<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GroupMovie extends Model
{
    use HasFactory;

   
    protected $casts = [
        'cast_id' => 'array',
       
    ];


    public function group()
    {
        
        return $this->belongsTo(Group::class, 'group_id')->whereNull('deleted_at');
    }

    public function movie()
    {
        
        return $this->belongsTo(Movie::class, 'movie_id')->whereNull('deleted_at');
    }
    
    
}
