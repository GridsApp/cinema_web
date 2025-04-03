<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    use HasFactory;
    protected $table = "survey_results";
    protected $casts = [
   ];
   protected $fillable = [
    'order_id',
    'user_id',
    'rating_movie',
    'rating_popcorn_pepsi',
    'rating_other_items',
    'rating_ticketing_service',
    'rating_cafeteria_service',
    'rating_users_service',
    'rating_ticketing_friendliness',
    'rating_cafeteria_friendliness',
    'rating_users_friendliness',
    'rating_ticketing_cleanliness',
    'rating_cafeteria_cleanliness',
    'rating_users_cleanliness',
    'rating_app',
    'message',
];


}