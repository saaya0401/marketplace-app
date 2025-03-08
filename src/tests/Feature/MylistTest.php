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
    protected $user;
    protected $items;
    protected $mylists;
    public  function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($this->user);

        $this->actingAs($this->user);

        $this->items=Item::all();
        Mylist::insert([
            [
                'user_id'=>$this->user->id,
                'item_id'=>$this->items[1]->id
            ],
            [
                'user_id'=>$this->user->id,
                'item_id'=>$this->items[2]->id
            ],
            [
                'user_id'=>$this->user->id,
                'item_id'=>$this->items[3]->id
            ]
        ]);
        $this->mylists=Mylist::where('user_id', $this->user->id)->get();
    }

    public function testMylist(){

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($this->mylists as $mylist){
            $response->assertSee($mylist->item->title);
            $response->assertSee($mylist->item->image);
        }
    }

    public function testSoldMylist(){
        $profiles=Profile::all();

        Purchase::insert([
            [
                'profile_id'=>$profiles[1]->id,
                'item_id'=>$this->items[1]->id,
                'payment_method'=>'カード払い'
            ],
            [
                'profile_id'=>$profiles[2]->id,
                'item_id'=>$this->items[2]->id,
                'payment_method'=>'カード払い'
            ]
        ]);

        $purchases=Purchase::all();

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($this->mylists as $mylist){
            $response->assertSee($mylist->item->title);
            $response->assertSee($mylist->item->image);
        }

        foreach($purchases as $purchase){
            $response->assertSee($purchase->title);
            $response->assertSee('Sold');
        }
    }

    public function testLoginUserMylist(){
        $userItems=Item::where('user_id', $this->user->id)->get();

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($this->mylists as $mylist)
        {
            $response->assertSee($mylist->item->title);
            $response->assertSee($mylist->item->image);
        }

        foreach($userItems as $item)
        {
            $response->assertDontSee($item->title);
            $response->assertDontSee($item->image);
        }
    }

    public function testGuestUserMylist(){
        $response=$this->post('/logout');
        $this->assertFalse(auth()->check());
        $response->assertRedirect('/');

        $response=$this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($this->mylists as $mylist)
        {
            $response->assertDontSee($mylist->item->title);
            $response->assertDontSee($mylist->item->image);
        }
    }
}
