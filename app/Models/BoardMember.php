<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BoardMember extends Model
{
    use HasFactory;

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['name_' . app()->getLocale()]
        );
    }


    protected function position(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['position_' . app()->getLocale()]
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['description_' . app()->getLocale()]
        );
    }
    
}
