<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Mylist;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public  function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testMylist(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);

        $this->actingAs($user);

        $items=Item::all();
        Mylist::insert([
            [
                'user_id'=>$user->id,
                'item_id'=>$items[1]->id,
            ],
            [
                'user_id'=>$user->id,
                'item_id'=>$items[3]->id,
            ]
        ]);

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        $mylists=Mylist::where(
            'user_id', $user->id)->get();
        foreach($mylists as $mylist){
            $response->assertSee($mylist->item->title);
            $response->assertSee($mylist->item->image);
        }
    }

    public function testSoldMylist(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);

        $this->actingAs($user);

        $profiles=Profile::all();
        $items=Item::all();
        Mylist::insert([
            [
                'user_id'=>$user->id,
                'item_id'=>$items[1]->id
            ],
            [
                'user_id'=>$user->id,
                'item_id'=>$items[2]->id
            ],
            [
                'user_id'=>$user->id,
                'item_id'=>$items[3]->id
            ]
            ]);


        $mylists=Mylist::whereIn('item_id', [$items[1]->id, $items[2]->id, $items[3]->id])->get();

        Purchase::insert([
            [
                'profile_id'=>$profiles[1]->id,
                'item_id'=>$items[1]->id,
                'payment_method'=>'カード払い'
            ],
            [
                'profile_id'=>$profiles[2]->id,
                'item_id'=>$items[2]->id,
                'payment_method'=>'カード払い'
            ]
        ]);

        $purchases=Purchase::whereIn('item_id', [$items[1]->id, $items[2]->id])->get();

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($mylists as $mylist){
            $response->assertSee($mylist->item->title);
            $response->assertSee($mylist->item->image);
        }

        foreach($purchases as $purchase){
            $response->assertSee($purchase->title);
            $response->assertSee('Sold');
        }
    }
}
