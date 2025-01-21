<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Branch extends Model
{
    use HasFactory;

    protected function label(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['label_' . app()->getLocale()]
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['description_' . app()->getLocale()]
        );
    }


    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['address_' . app()->getLocale()]
        );
    }
    

    
}
