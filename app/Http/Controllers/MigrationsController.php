<?php

namespace App\Http\Controllers;

use App\Models\PriceGroupZone;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigrationsController extends Controller
{

    // public function theaters()
    // {
    //     $branch_mapping = [
    //         "1" => 1,
    //         "4" => 2,
    //         "3" => 3,
    //         "2" => 4,
    //         "9" => 5,
    //         "10" => 6,
    //         "12" => 7,
    //         "13" => 8,
    //         "8" => 9,
    //         "14" => 10,
    //     ];


    //     $theaters = DB::connection('iraqi_cinema_old')
    //         ->table('theaters')
    //         ->get();

    //     foreach($theaters as $theater){

    //         preg_match('/\d+/', $theater->label, $matches);

    //        $new_theater = new Theater;
    //        $new_theater->label = $theater->label;
    //        $new_theater->branch_id = $branch_mapping[$theater->cinema_id];
    //        $new_theater->hall_number = $matches[0] ?? null; 
           
    //        $new_theater->price_group_id = 
    //        $new_theater->theater_map = 
    //        $new_theater->nb_seats = 
    //        $new_theater->save();




    //         $cells = DB::connection('iraqi_cinema_old')->table('cells')->where('cancelled',0)->where('theater_id', $theater->uuid)->where('cancelled',0)->orderBy('abscissa', 'ASC')->orderBy('ordinate', 'ASC')->get()->keyBy('code');
          
    //         $cells_zones = $cells->unique('zone_id')->pluck('zone_id')->filter(function ($value) { return !is_null($value); })->values()->toArray();

    //         $zones = DB::connection('iraqi_cinema_old')->table('zones')->where('cancelled',0)->whereIn('id',$cells_zones)->get()->keyBy('id');
    
            
    


    //         $cells = $cells->map(function($cell) use ($zones , $theater) {
                


    //             $old_zone = isset($zones[$cell->zone_id]) ? $zones[$cell->zone_id] : null;

               

    //             PriceGroupZone::where('label' , )-

    //             Movie



                
    //             return $this->createCell($cell->is_seat == 0 ? "empty" : "seat", $cell->label , $cell->id ,in_array($cell->label , $reserved) ? 1 : 0 , isset($zones[$cell->zone_id]) ? $zones[$cell->zone_id] : null , isset($zones[$cell->zone_id]) ? $zones[$cell->zone_id]['disabled']: 0);
           

    //             return [
    //             "isSeat" => true,
    //             "color" => "#6b7280",
    //             "zone" => null,
    //             "code"=> "A12",
    //             "row" => "A",
    //             "column" => 12

    //             ];

    //             return [
    //                 "id" => $id,
    //                 "type" => $type,
    //                 "cell" => $label,
    //                 "reserved" => $reserved,
    //                 "disabled" => $disabled,
    //                 "color" =>  $zone && isset($zone->color) ? ($reserved ? $reserved_color : $zone->color) : ($reserved ?  $reserved_color : $available_color),
    //                 "zone_id" => $zone->id ?? null
    //         ];
           
    //         });





    //     }


    //     dd($theaters);
    // }



    public function posUsers(){



        $branch_mapping = [
                    "1" => 1,
                    "4" => 2,
                    "3" => 3,
                    "2" => 4,
                    "9" => 5,
                    "10" => 6,
                    "12" => 7,
                    "13" => 8,
                    "8" => 9,
                    "14" => 10,
                ];
        
             $old_pos_users=   DB::connection('iraqi_cinema_old')
                        ->table('pos_users')
                        ->where('cancelled',0)
                        ->where('active' , 1)
                        ->get()->map(function($pos_user) use($branch_mapping){
                            return [
                                'name' => $pos_user->name,
                                'username' => $pos_user->username,
                                'passcode' => $pos_user->password,
                                'pincode' => $pos_user->pin,
                                'branch_id' => $branch_mapping[$pos_user->cinema_id],
                                'role' => $pos_user->user_role,
                            ];
                        });

                        dd($old_pos_users);



        $array = [
            'name',
            'username',
            'passcode',
            'pincode',
            'branch_id',
            'role',
        ];

    }
}
