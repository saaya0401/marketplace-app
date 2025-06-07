<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchases=[
            [
                'profile_id'=>1,
                'item_id'=>6,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
            [
                'profile_id'=>2,
                'item_id'=>1,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
            [
                'profile_id'=>3,
                'item_id'=>2,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
            [
                'profile_id'=>3,
                'item_id'=>3,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
            [
                'profile_id'=>3,
                'item_id'=>7,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
            [
                'profile_id'=>3,
                'item_id'=>8,
                'payment_method'=>'card',
                'status'=>'in_progress'
            ],
        ];

        foreach($purchases as $purchase){
            Purchase::create($purchase);
        }
    }
}
