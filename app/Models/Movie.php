<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Movie extends Model
{
    use HasFactory, Searchable;


    protected $casts = [
        'cast_id' => 'array',
        'genre_id' => 'array', 
    ];


    public function movieShows()
    {
        return $this->hasMany(MovieShow::class, 'movie_id')->whereNull('deleted_at');
    }
    
}
