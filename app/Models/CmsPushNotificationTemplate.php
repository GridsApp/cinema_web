<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CmsPushNotificationTemplate extends Model
{
    use HasFactory;
    

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['title_'.app()->getLocale()]  
        );
    }

    protected function message(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['message_'.app()->getLocale()]  
        );
    }


    

}
