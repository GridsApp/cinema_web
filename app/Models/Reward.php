<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reward extends Model
{
    use HasFactory;

    protected $casts = [
        'zones' => 'array',
        'items' => 'array'
    ];
}
