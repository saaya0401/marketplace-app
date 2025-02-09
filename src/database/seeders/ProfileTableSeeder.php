<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles=[
            [
                'user_id'=>1,
                'profile_image'=>'profile-img/elephant.png',
                'postal_code'=>'123-4567',
                'address'=>'大阪府高槻市'
            ],
            [
                'user_id'=>2,
                'profile_image'=>'profile-img/elephant.png',
                'postal_code'=>'123-4567',
                'address'=>'大阪府高槻市'
            ],
            [
                'user_id'=>3,
                'profile_image'=>'profile-img/elephant.png',
                'postal_code'=>'123-4567',
                'address'=>'大阪府高槻市'
            ],
            [
                'user_id'=>4,
                'profile_image'=>'profile-img/elephant.png',
                'postal_code'=>'123-4567',
                'address'=>'大阪府高槻市'
            ],
            [
                'user_id'=>5,
                'profile_image'=>'profile-img/elephant.png',
                'postal_code'=>'123-4567',
                'address'=>'大阪府高槻市'
            ]
        ];
        foreach($profiles as $profile){
            Profile::create($profile);
        }
    }
}
