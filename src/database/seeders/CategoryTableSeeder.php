<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories=[
            ['name'=>'ファッション'],
            ['name'=>'家電'],
            ['name'=>'インテリア'],
            ['name'=>'レディース'],
            ['name'=>'メンズ'],
            ['name'=>'コスメ'],
            ['name'=>'本'],
            ['name'=>'ゲーム'],
            ['name'=>'スポーツ'],
            ['name'=>'キッチン'],
            ['name'=>'ハンドメイド'],
            ['name'=>'アクセサリー'],
            ['name'=>'おもちゃ'],
            ['name'=>'ベビー・キッズ']
        ];
        foreach($categories as $category){
            Category::create($category);
        }
    }
}
