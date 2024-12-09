<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheaterMap extends Model
{
    use HasFactory;

    // map

    /*

        $cell_seat = {
            "type" : "SEAT",
            "zone_id" : "1",
            "row_index" => "0",
            "column_index" : "0",
            "label" : "A1"
        }  
        
        $cell_empty = {
            "type" : "EMPTY",
            "row_index" => "0",
            "column_index" : "8"
        }  


       $map =  [
            {
                "type" : "SEAT",
                "row_index" => "0",
                "column_index" : "0",
                
                "zone_id" : "1",
                "seat" : "A1"
            },
            {
                "type" : "SEAT",
                "row_index" => "0",
                "column_index" : "1",

                "zone_id" : "1",
                "seat" : "A1"
            },
            {
                "type" : "EMPTY",
                "row_index" => "0",
                "column_index" : "8"
            }  

        ]


    */

}
