<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param=[
            'condition'=>'良好'
        ];
        DB::table('conditions')->insert($param);;
        $param=[
            'condition'=>'目立った傷や汚れなし'
        ];
        DB::table('conditions')->insert($param);
        $param=[
            'condition'=>'やや傷や汚れあり'
        ];
        DB::table('conditions')->insert($param);
        $param=[
            'condition'=>'状態が悪い'
        ];
        DB::table('conditions')->insert($param);
    }
}
