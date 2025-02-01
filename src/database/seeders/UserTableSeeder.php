<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
            'name'=>'koharu',
            'email'=>'koharu@example.com',
            'password'=>Hash::make('koharukoba')
            ],
            [
            'name'=>'hiyori',
            'email'=>'hiyori@example.com',
            'password'=>Hash::make('hiyorikoba')
            ],
            [
            'name'=>'yasu',
            'email'=>'yasu@example.com',
            'password'=>Hash::make('yasukoba')
            ],
            [
            'name'=>'sarasa',
            'email'=>'sarasa@example.com',
            'password'=>Hash::make('sarasakoba')
            ],
            [
            'name'=>'saaya',
            'email'=>'saaya@example.com',
            'password'=>Hash::make('saayakoba')
            ],
        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
