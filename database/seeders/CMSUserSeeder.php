<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CMSUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'first_name' => "Hovig",
                'last_name' => "Senekjian",
                'email' => 'hovig@thewebaddicts.com',
                'password' => md5('changeme')
            ],
            [
                'first_name' => "Nourhane",
                'last_name' => "Sarieddine",
                'email' => 'nourhane.sarieddine@thewebaddicts.com',
                'password' => md5('changeme')
            ]
        ];

        foreach($users as $user){
            $existing_user = DB::table('cms_users')->where("email" , $user['email'])->first();
            if($existing_user){ continue; }
            DB::table('cms_users')->insert($user);
        }

         
    }
}
