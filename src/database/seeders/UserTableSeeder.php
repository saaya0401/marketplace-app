<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
            'name'=>'saaya',
            'email'=>'saaya@example.com',
            'password'=>'saayakoba',
            'email_verified_at'=>Carbon::now(),
            ],
            [
            'name'=>'hiyori',
            'email'=>'hiyori@example.com',
            'password'=>'hiyorikoba',
            'email_verified_at'=>Carbon::now(),
            ],
            [
            'name'=>'yasu',
            'email'=>'yasu@example.com',
            'password'=>'yasukoba',
            'email_verified_at'=>Carbon::now(),
            ],
            [
            'name'=>'sarasa',
            'email'=>'sarasa@example.com',
            'password'=>'sarasakoba',
            'email_verified_at'=>Carbon::now(),
            ],
            [
            'name'=>'koharu',
            'email'=>'koharu@example.com',
            'password'=>'koharukoba',
            'email_verified_at'=>Carbon::now(),
            ],
        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
