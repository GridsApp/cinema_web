<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceGroupZone extends Model
{
    use HasFactory;


    //conditions


    /*
  
    PHP
    
        $conditions = [
            [
               [
                "type" => "DAYS",
                "payload" => ["monday" , "wednesday" , "friday"]
               ], //OR
               [
                "type" => "DATE_RANGE",
                "payload" => [
                        "from" => "12-09-2024",
                        "to" => "20-09-2024"
                    ]
                ],
               [
                "type" => "TIME_RANGE",
                "payload" => [
                        "from" => "17:00",
                        "to" => "23:00"
                    ]
           
               ],
               [
                "type" => "MOVIES",
                "payload" => [
                        "1",
                        "2",
                        "3"
                    ]
                
               ]
            ], //AND

             [
               [
                "type" => "DAYS",
                "payload" => ["monday" , "wednesday" , "friday"]
               ],
               [
                "type" => "DATE_RANGE",
                "payload" => [
                        "from" => "12-09-2024",
                        "to" => "20-09-2024"
                    ]
                ],
               [
                "type" => "TIME_RANGE",
                "payload" => [
                        "from" => "17:00",
                        "to" => "23:00"
                    ]
               ],
               [
                "type" => "MOVIES",
                "payload" => [
                        "1",
                        "2",
                        "3"
                    ]
                ],
               
            ],
           
        ]

        JSON ENCODED

          $conditions = [
            [
               {
                "type" => "DAYS",
                "payload" => ["monday" , "wednesday" , "friday"]
               }, //OR
               {
                "type" => "DATE_RANGE",
                "payload" => {
                        "from" => "12-09-2024",
                        "to" => "20-09-2024"
                    }
                },
               {
                "type" => "TIME_RANGE",
                "payload" => {
                        "from" => "17:00",
                        "to" => "23:00"
                    }
                },
               {
                "type" => "MOVIES",
                "payload" => [
                        "1",
                        "2",
                        "3"
                    ]
                }
                
            }, //AND

             [
               {
                "type" => "DAYS",
                "payload" => ["monday" , "wednesday" , "friday"]
               },
               {
                "type" => "DATE_RANGE",
                "payload" => {
                        "from" => "12-09-2024",
                        "to" => "20-09-2024"
                    }
                },
               {
                "type" => "TIME_RANGE",
                "payload" => {
                        "from" => "17:00",
                        "to" => "23:00"
                },
               {
                "type" => "MOVIES",
                "payload" => [
                        "1",
                        "2",
                        "3"
                    ]
                }
               
            ]
           
        ]

    */
}
