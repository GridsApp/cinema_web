<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Slideshow extends Model
{
    use HasFactory;

    protected function label(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['label_'.app()->getLocale()]  
        );
    }

    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['text_'.app()->getLocale()]  
        );
    }

    protected function ctaLabel(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['cta_label_'.app()->getLocale()]  
        );
    }

    protected function ctaLink(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['cta_link_'.app()->getLocale()]  
        );
    }



   
}
