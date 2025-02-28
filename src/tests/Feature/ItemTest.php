<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public  function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testAllItems(){
        $response=$this->get('/');
        $response->assertStatus(200);

        $items=Item::all();
        foreach($items as $item){
            $response->assertSee($item->title);
            $response->assertSee($item->image);
        }
    }

    public function testSoldItems(){
        $items=Item::all();
        $users=User::all();
        $profiles=Profile::with('user')->get();

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

        $response=$this->get('/');
        $response->assertStatus(200);

        $purchases=Purchase::whereIn('item_id', [$items[1]->id, $items[2]->id])->get();
        foreach($purchases as $purchase){
            $response->assertSee('Sold');
        }
    }

    public function testLoginUserItems(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);
        $userItems=Item::where('user_id', $user->id)->get();

        $this->actingAs($user);
        $response=$this->get('/');
        $response->Status(200);

        foreach($userItems as $item){
            $response->assertDontSee($item->title);
            $response->assertDontSee($item->image);
        }
    }
}
