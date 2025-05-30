<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTimeIds extends Command
{
    protected $signature = 'times:update-ids';
    protected $description = 'Update time IDs across movie_shows, order_seats, and cart_seats tables';

    public function handle()
    {
        // Add treated_time_id columns if they don't exist
        if (!Schema::hasColumn('movie_shows', 'treated_time_id')) {
            DB::statement('ALTER TABLE movie_shows ADD COLUMN treated_time_id TINYINT DEFAULT 0');
        }
        if (!Schema::hasColumn('movie_shows', 'treated_end_time_id')) {
            DB::statement('ALTER TABLE movie_shows ADD COLUMN treated_end_time_id TINYINT DEFAULT 0');
        }
        if (!Schema::hasColumn('order_seats', 'treated_time_id')) {
            DB::statement('ALTER TABLE order_seats ADD COLUMN treated_time_id TINYINT DEFAULT 0');
        }
        if (!Schema::hasColumn('cart_seats', 'treated_time_id')) {
            DB::statement('ALTER TABLE cart_seats ADD COLUMN treated_time_id TINYINT DEFAULT 0');
        }

        // Define your time ID mappings here
        $mappings = [
            1 => 41,   // 10:00 -> 00:00
            2 => 42,   // 10:15 -> 00:15
            3 => 43,   // 10:30 -> 00:30
            4 => 44,   // 10:45 -> 00:45
            5 => 45,   // 11:00 -> 01:00
            6 => 46,   // 11:15 -> 01:15
            7 => 47,   // 11:30 -> 01:30
            8 => 48,   // 11:45 -> 01:45
            9 => 49,   // 12:00 -> 02:00
            10 => 50,  // 12:15 -> 02:15
            11 => 51,  // 12:30 -> 02:30
            12 => 52,  // 12:45 -> 02:45
            13 => 53,  // 13:00 -> 03:00
            14 => 54,  // 13:15 -> 03:15
            15 => 55,  // 13:30 -> 03:30
            16 => 56,  // 13:45 -> 03:45
            17 => 57,  // 14:00 -> 04:00
            18 => 58,  // 14:15 -> 04:15
            19 => 59,  // 14:30 -> 04:30
            20 => 60,  // 14:45 -> 04:45
            21 => 61,  // 15:00 -> 05:00
            22 => 62,  // 15:15 -> 05:15
            23 => 63,  // 15:30 -> 05:30
            24 => 64,  // 15:45 -> 05:45
            25 => 65,  // 16:00 -> 06:00
            26 => 66,  // 16:15 -> 06:15
            27 => 67,  // 16:30 -> 06:30
            28 => 68,  // 16:45 -> 06:45
            29 => 69,  // 17:00 -> 07:00
            30 => 70,  // 17:15 -> 07:15
            31 => 71,  // 17:30 -> 07:30
            32 => 72,  // 17:45 -> 07:45
            33 => 73,  // 18:00 -> 08:00
            34 => 74,  // 18:15 -> 08:15
            35 => 75,  // 18:30 -> 08:30
            36 => 76,  // 18:45 -> 08:45
            37 => 77,  // 19:00 -> 09:00
            38 => 78,  // 19:15 -> 09:15
            39 => 79,  // 19:30 -> 09:30
            40 => 80,  // 19:45 -> 09:45
            41 => 81,  // 20:00 -> 10:00
            42 => 82,  // 20:15 -> 10:15
            43 => 83,  // 20:30 -> 10:30
            44 => 84,  // 20:45 -> 10:45
            45 => 85,  // 21:00 -> 11:00
            46 => 86,  // 21:15 -> 11:15
            47 => 87,  // 21:30 -> 11:30
            48 => 88,  // 21:45 -> 11:45
            49 => 89,  // 22:00 -> 12:00
            50 => 90,  // 22:15 -> 12:15
            51 => 91,  // 22:30 -> 12:30
            52 => 92,  // 22:45 -> 12:45
            53 => 93,  // 23:00 -> 13:00
            54 => 94,  // 23:15 -> 13:15
            55 => 95,  // 23:30 -> 13:30
            56 => 96,  // 23:45 -> 13:45
        ];

        DB::beginTransaction();
        try {
            // Update movie_shows table
            foreach ($mappings as $oldId => $newId) {
                DB::table('movie_shows')
                    ->where('time_id', $oldId)
                    ->where('treated_time_id', '!=', 1)
                    ->update(['time_id' => $newId, 'treated_time_id' => 1]);

                DB::table('movie_shows')
                    ->where('end_time_id', $oldId)
                    ->where('treated_end_time_id', '!=', 1)
                    ->update(['end_time_id' => $newId, 'treated_end_time_id' => 1]);
            }

            // Update order_seats table
            foreach ($mappings as $oldId => $newId) {
                DB::table('order_seats')
                    ->where('time_id', $oldId)
                    ->where('treated_time_id', '!=', 1)
                    ->update(['time_id' => $newId, 'treated_time_id' => 1]);
            }

            // Update cart_seats table
            foreach ($mappings as $oldId => $newId) {
                DB::table('cart_seats')
                    ->where('time_id', $oldId)
                    ->where('treated_time_id', '!=', 1)
                    ->update(['time_id' => $newId, 'treated_time_id' => 1]);
            }

            DB::commit();
            $this->info('Time IDs updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error updating time IDs: ' . $e->getMessage());
        }
    }
} 