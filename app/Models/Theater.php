<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    protected $casts = [
        'theater_map' => 'array'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id' , 'id');
    }
    public function movieShows()
    {
        return $this->hasMany(MovieShow::class, 'theater_id');
    }

    public function priceGroup()
    {
        return $this->belongsTo(PriceGroup::class, 'price_group_id');
    }

}
