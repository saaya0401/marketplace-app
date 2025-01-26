<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=[
            'name'=>'saaya',
            'email'=>'saaya@example.com',
            'password'=>Hash::make('saayakoba')
        ];
        DB::table('users')->insert($user);
    }
}
