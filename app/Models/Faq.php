<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Faq extends Model
{
    use HasFactory;


    protected function question(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['question_'.app()->getLocale()]  
        );
    }

    protected function answer(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['answer_'.app()->getLocale()]  
        );
    }

}
