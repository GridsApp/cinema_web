<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Faker\Factory as Faker;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $start = Carbon::createFromTime(10, 0);
        $end = Carbon::createFromTime(23, 0);


        DB::table('times')->truncate();

        while ($start <= $end) {
            DB::table('times')->insert([
                'iso' => $start->format('H:i'),
                'label' => $start->format('h:i A')
            ]);

            $start->addMinutes(15);
        }



    }
}
