<?php

namespace App\Http\Controllers;

use App\Models\OrderSeat;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use App\Models\UserCard;
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


    public function migrateCoupons()
    {


        $used = DB::table('coupons')->get()->pluck('code')->toArray();

        $coupons = DB::connection('iraqi_cinema_old')->table('coupons')
            ->whereNotIn('id', function ($query) {
                $query->select(DB::raw('DISTINCT coupon_id'))
                    ->from('purchases')
                    ->whereNotNull('coupon_id');
            })
            ->where('cancelled', 0)
            ->whereNotIn('code', $used)
            ->where('archived', '!=', 1)
            ->get()->map(function ($item) {
                return [
                    'label' => $item->label,
                    'code' => $item->code,
                    'discount_flat' => $item->discount_flat,
                    'expires_at' => $item->expires_at,
                ];
            })->toArray();


        DB::table('coupons')->insert($coupons);

        echo "DONE";
    }


    public function migrateUsers($limit, $consoleThis)
    {

        // $limit = 10000;



        $reward_mapping = [
            "1" => 7,
            "2" => 7,
            "3" => 2,
            "4" => 8,
            "5" => 9,
            "7" => 7,
            "8" => 10,
            "9" => 5,
            "10" => 6,
            "11" => 4,
            "12" => 1,
            "13" => 3
        ];


        $users = DB::connection('iraqi_cinema_old')
            ->table('users')
            ->where('treated', 0)
            ->where('cancelled', 0)
            // ->where('id' , 95905)
            ->where('segment', 'B')
            ->limit($limit)
            ->get();





        foreach ($users as $index => $user) {
            $info = [
                'old_user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => $user->password,
                'dob' => $user->dob,
                'dom' => $user->dom,
                'gender' => $user->gender,
                'login_provider' => $user->provider,
                'identifier' => $user->identifier,
                'phone_verified_at' => 1,
                'email_verified_at' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];



            try {

                DB::beginTransaction();

                // Check for transactions for this user id

                $card = DB::connection('iraqi_cinema_old')->table('user_loyalty_cards')
                    ->where('expired', '!=', 1)
                    ->where('cancelled', 0)
                    ->where('user_id', $user->id)
                    ->orderBy('id', 'DESC')
                    ->first();


                $new_user_id = DB::table('users')->insertGetId($info);

                $total_wallet_balance = 0;
                $total_loyalty_balance  = 0;

                if ($card) {
                    $total_wallet_balance = DB::connection('iraqi_cinema_old')->table('user_wallet_transactions')
                        ->selectRaw("
                        SUM(CASE WHEN type = 'topup' THEN amount ELSE 0 END) -
                        SUM(CASE WHEN type = 'deduct' THEN amount ELSE 0 END) as balance
                ")
                        ->where('user_id', $user->id)
                        ->where('cancelled', 0)
                        ->value('balance');

                    $total_loyalty_balance = DB::connection('iraqi_cinema_old')->table('user_loyalty_point_transactions')
                        ->selectRaw("
                        SUM(CASE WHEN type = 'add' THEN amount ELSE 0 END) -
                        SUM(CASE WHEN type = 'deduct' THEN amount ELSE 0 END) as balance
                ")
                        ->where('user_id', $user->id)
                        ->where('cancelled', 0)
                        ->value('balance');

                    $card_number = $card->card_number;
                    $card_type = strlen($card_number) == 16 ? 'physical' : 'digital';
                } else {

                    do {
                        $card_number = (string) rand(10000000000000000, 99999999999999999);
                    } while (UserCard::where('barcode', $card_number)->whereNull('deleted_at')->first());

                    $card_type = 'digital';
                }



                $card_id = DB::table('user_cards')->insertGetId([
                    'user_id' => $new_user_id,
                    'barcode' => $card_number,
                    'type' => $card_type,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);



                if ($total_wallet_balance > 0) {
                    $user_wallet_transactions_id =   DB::table('user_wallet_transactions')->insertGetId([
                        'user_card_id' => $card_id,
                        'type' => 'in',
                        'amount' => $total_wallet_balance,
                        'balance' =>  $total_wallet_balance,
                        'description' => 'System Migration',
                        'user_id' => $new_user_id,
                        'reference' => 'SYS',

                        'system_id' => 5,
                        'transactionable_id' => 1,
                        'transactionable_type' => 'twa\cmsv2\Models\CmsUser',

                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('user_wallet_transactions')->where('id', $user_wallet_transactions_id)->update([
                        'long_id' => generateLongId($user_wallet_transactions_id)
                    ]);
                }

                if ($total_loyalty_balance > 0) {
                    $user_loyalty_transactions_id = DB::table('user_loyalty_transactions')->insertGetId([
                        'user_card_id' => $card_id,
                        'type' => 'in',
                        'amount' => $total_loyalty_balance,
                        'balance' =>  $total_loyalty_balance,
                        'description' => 'System Migration',
                        'user_id' => $new_user_id,
                        'reference' => 'SYS',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('user_loyalty_transactions')->where('id', $user_loyalty_transactions_id)->update([
                        'long_id' => generateLongId($user_loyalty_transactions_id)
                    ]);
                }


                $redeem_rewards = DB::connection('iraqi_cinema_old')
                    ->table('redeem_rewards')
                    ->where('cancelled', 0)
                    ->where('used', '!=', 1)
                    ->where('user_id', $user->id)
                    ->get()->map(function ($reward) use ($new_user_id, $reward_mapping) {
                        return [
                            'user_id' => $new_user_id,
                            'reward_id' => $reward_mapping[$reward->reward_id],
                            'code' => $reward->code,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    })->toArray();


                DB::table('user_rewards')->insert($redeem_rewards);



                DB::connection('iraqi_cinema_old')


                    ->table('users')
                    ->where('id', $user->id)
                    ->update([
                        'treated' => 1
                    ]);

                $consoleThis->comment('DONE :' . count($users) . ' / ' . $index + 1 . ' | ID:' . $user->id);

                DB::commit();
            } catch (\Throwable $th) {

                DB::rollBack();

                $consoleThis->comment('ERROR :' . count($users) . ' / ' . $index + 1 . 'ID:' . $user->id);

                dd($th);
            }
        }

    }


    public function posUsers()
    {



        $branch_mapping = [
            "1" => 1,
            "4" => 4,
            "3" => 3,
            "2" => 2,
            "9" => 6,
            "10" => 7,
            "12" => 8,
            "13" => 9,
            "8" => 5,
            "14" => 10,
        ];




        $old_pos_users =   DB::connection('iraqi_cinema_old')
            ->table('pos_users')
            ->where('cancelled', 0)
            ->where('active', 1)
            ->whereNotNull('cinema_id')
            ->get()->map(function ($pos_user) use ($branch_mapping) {
                return [
                    'name' => $pos_user->name,
                    'username' => $pos_user->username,
                    'passcode' => $pos_user->password,
                    'pincode' => $pos_user->pin,
                    'branch_id' => $branch_mapping[$pos_user->cinema_id],
                    'role' => $pos_user->user_role,
                ];
            })->toArray();



        $affected = DB::table('pos_users')->insert($old_pos_users);


        dd($affected);

        // $array = [
        //     'name',
        //     'username',
        //     'passcode',
        //     'pincode',
        //     'branch_id',
        //     'role',
        // ];

    }


    public function week()
    {

        $movie_weeks = [
            5 => 6,
            11 => 3,
            14 => 3,
            17 => 2,
            18 => 2,
            19 => 2,
            20 => 2,
        ];


        $wed = now()->parse('08-05-2025');

        foreach ($movie_weeks as $movie_id => $week) {

            DB::table('order_seats')
                ->whereDate('date', '>=', $wed)
                ->where('movie_id', $movie_id)->update([
                    'week' => $week + 1,
                    'dist_share_percentage' => null,
                    'dist_share_amount' => null
                ]);

            DB::table('movie_shows')
                ->whereDate('date', '>=', $wed)
                ->where('movie_id', $movie_id)->update([
                    'week' => $week + 1
                ]);
        }
    }


    public function calculateDistShare($limit = 1000, $thisParent)
    {


        $order_seats = OrderSeat::select(
            'order_seats.id',
            'order_seats.week',
            'order_seats.price',
            'order_seats.dist_share_percentage',
            'order_seats.dist_share_amount',
            'movies.commission_settings'
        )->where(function ($q) {
            $q->orWhereNull('order_seats.dist_share_percentage');
            $q->orWhereNull('order_seats.dist_share_amount');
        })
            ->join('movies', 'order_seats.movie_id', 'movies.id')
            ->limit($limit)->get();


        $count = count($order_seats);
        foreach ($order_seats as $i => $order_seat) {


            $settings = json_decode($order_seat->commission_settings, true);

            $week = $order_seat->week;
            $conditions = $settings['conditions'] ?? [];
            $defaultPercentage = $settings['defaultPercentage'] ?? 0;


            $index = $week - 1;

            if (isset($conditions[$index])) {
                $dist_share_percentage = $conditions[$index];
            } else {
                $dist_share_percentage = $defaultPercentage;
            }

            $order_seat->dist_share_percentage = $dist_share_percentage;
            $order_seat->dist_share_amount = calculate_share_amount($order_seat->price, $dist_share_percentage, 5);
            $order_seat->save();


            $thisParent->comment("Completed :" . ($i + 1) . "/" . $count);
        }
    }

    public function addCoupons() {

        // $path = storage_path('app/data.csv');
        $path = public_path('coupons/batch_01_06_2025.csv');

        if (!file_exists($path) || !is_readable($path)) {
            return response()->json(['error' => 'CSV file not found or not readable.'], 400);
        }

        $header = null;
        $data = [];

        if (($handle = fopen($path, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        foreach ($data as $row) {

            $found = DB::table('coupons')->where('code' , $row['code'])->first();

            if(!$found){
                DB::table('coupons')->insert([
                    'label' => $row['label'],
                    'code' => $row['code'],
                    'discount_flat' => $row['discount_flat'],
                    'expires_at' => $row['expires_at'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return response()->json(['message' => 'CSV imported successfully.']);

    }


    public function treatJsonReferences(){
        // Get all orders where payment_reference contains a JSON-like string
        $orders = DB::table('orders')
            ->where('payment_reference', 'LIKE', '%{%')
            ->get();

        foreach ($orders as $order) {
            try {
                // Remove the trailing quote and add the closing brace
                $jsonStr = rtrim($order->payment_reference, '"') . '"}';

                // dd($jsonStr);
                // Decode the JSON
                $jsonData = json_decode($jsonStr, true);
                // dd($jsonData);
                if ($jsonData && isset($jsonData['ecrRef'])) {
                    // Update the payment_reference with the ecrRef value
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update([
                            'payment_reference' => $jsonData['ecrRef']
                        ]);
                }
            } catch (\Exception $e) {
                // Log error or handle it as needed
                continue;
            }
        }

        return response()->json(['message' => 'Payment references updated successfully.']);
    }
}
