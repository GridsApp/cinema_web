<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
    use HasFactory, Searchable;


    protected $casts = [
        'cast_id' => 'array',
        'genre_id' => 'array', 
    ];

// In the Movie model
// public function movieGenres()
// {
//     return $this->hasMany(MovieGenre::class, 'id', 'genre_id');
// }
public function genre()
{
    return $this->belongsTo(MovieGenre::class, 'genre_id')->whereNull('deleted_at');
}

public function movieShows()
{
    return $this->hasMany(MovieShow::class);
}


protected function description(): Attribute
{
    return Attribute::make(
        get: fn(mixed $value, array $attributes) => $attributes['description_'.app()->getLocale()]  
    );
}
public function distributor()
{
    
    return $this->belongsTo(Distributor::class, 'distributor_id')->whereNull('deleted_at');
}

}
