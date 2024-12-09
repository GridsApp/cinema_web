<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorShare extends Model
{
    use HasFactory;

    /*
  
    PHP
    
        $conditions = [
            [
                "week" => 1,
                "percentage" => 50
            ],
            [
                "week" => 2,
                "percentage" => 45
            ],
            [
                "week" => 3,
                "percentage" => 40
            ]
        ]

    JSON ENCODED

       $conditions = [
            {
                "week" : 1,
                "percentage" : 50
            },
            {
                "week" : 2,
                "percentage" : 45
            },
            {
                "week" : 3,
                "percentage" : 40
            }
        ]

    */

}
