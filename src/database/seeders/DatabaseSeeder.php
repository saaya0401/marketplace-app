<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        \DB::commit();

        $this->call([
            ProfileTableSeeder::class,
            ConditionTableSeeder::class,
            CategoryTableSeeder::class,
        ]);

        \DB::commit();
        $this->call(ItemTableSeeder::class);
    }
}
