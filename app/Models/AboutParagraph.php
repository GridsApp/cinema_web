<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AboutParagraph extends Model
{
    use HasFactory;

  
    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['content_' . app()->getLocale()]
        );
    }
}
