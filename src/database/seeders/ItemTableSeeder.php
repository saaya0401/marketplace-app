<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds=Category::pluck('id')->toArray();
        $items=[
            [
                'title'=>'腕時計',
                'description'=>'スタイリッシュなデザインのメンズ腕時計',
                'image'=>'item-img/Clock.png',
                'price'=>15000,
                'condition_id'=>1,
                'user_id'=>1,
                'categories'=>[1,5]
            ],
            [
                'title'=>'HDD',
                'description'=>'高速で信頼性の高いハードディスク',
                'image'=>'item-img/Disk.png',
                'price'=>5000,
                'condition_id'=>2,
                'user_id'=>1,
                'categories'=>[8,13]
            ],
            [
                'title'=>'玉ねぎ３束',
                'description'=>'新鮮な玉ねぎ３束のセット',
                'image'=>'item-img/Love.png',
                'price'=>300,
                'condition_id'=>3,
                'user_id'=>1,
                'categories'=>[10]
            ],
            [
                'title'=>'革靴',
                'description'=>'クラシックなデザインの革靴',
                'image'=>'item-img/Shoes.png',
                'price'=>4000,
                'condition_id'=>4,
                'user_id'=>1,
                'categories'=>[1,4,5]
            ],
            [
                'title'=>'ノートPC',
                'description'=>'高性能なノートパソコン',
                'image'=>'item-img/Laptop.png',
                'price'=>45000,
                'condition_id'=>1,
                'user_id'=>1,
                'categories'=>[2,3,13]
            ],
            [
                'title'=>'マイク',
                'description'=>'高音質のレコーディング用マイク',
                'image'=>'item-img/Music.png',
                'price'=>8000,
                'condition_id'=>2,
                'user_id'=>2,
                'categories'=>[13]
            ],
            [
                'title'=>'ショルダーバッグ',
                'description'=>'おしゃれなショルダーバッグ',
                'image'=>'item-img/Purse.png',
                'price'=>3500,
                'condition_id'=>3,
                'user_id'=>2,
                'categories'=>[1,4]
            ],
            [
                'title'=>'タンブラー',
                'description'=>'使いやすいタンブラー',
                'image'=>'item-img/Tumbler.png',
                'price'=>500,
                'condition_id'=>4,
                'user_id'=>2,
                'categories'=>[10,14]
            ],
            [
                'title'=>'コーヒーミル',
                'description'=>'手動のコーヒーミル',
                'image'=>'item-img/Waitress.png',
                'price'=>4000,
                'condition_id'=>1,
                'user_id'=>2,
                'categories'=>[2,10]
            ],
            [
                'title'=>'メイクセット',
                'description'=>'便利なメイクアップセット',
                'image'=>'item-img/makeup.png',
                'price'=>2500,
                'condition_id'=>2,
                'user_id'=>2,
                'categories'=>[6]
            ]
        ];
        foreach($items as $itemData){
            $item=Item::create([
                'title'=>$itemData['title'],
                'description'=>$itemData['description'],
                'image'=>$itemData['image'],
                'price'=>$itemData['price'],
                'condition_id'=>$itemData['condition_id'],
                'user_id'=>$itemData['user_id'],
            ]);
            if(isset($itemData['categories'])){
                $item->categories()->attach($itemData['categories']);
            }
        }
    }
}
