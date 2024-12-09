<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ScreenTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $data = [];
        for ($i = 0; $i < 10000; $i++) {
            $data[] = [
                'label' => $faker->name,
            ];

            if (count($data) % 500 === 0) {
                DB::table('screen_types')->insert($data);
                $data = [];
            }
        }
        
        if (count($data) > 0) {
            DB::table('screen_types')->insert($data);
        }
    }
}
