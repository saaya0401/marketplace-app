<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Mylist;


class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSearch(){
        $keyword='H';
        $response=$this->get('/item/search?keyword=H');
        $response->assertStatus(200);

        $items=Item::query()->KeywordSearch($keyword)->get();
        $response->assertViewHas('items', function($items) {
            return $items->count() === 1 && $items->first()->title ==='HDD';
        });
    }

    public function testSearchMylist(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user);

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

        $keyword='H';
        $response=$this->get('/item/search?keyword=' . $keyword);
        $response->assertStatus(200);

        $expectedItems=Item::where('title', 'like', "%{$keyword}%")->where('user_id', '!=', $user->id)->get();
        $response->assertViewHas('items', function($items) use ($expectedItems){
            return $items->count() === $expectedItems->count() && $items->pluck('title')->first() === $expectedItems->pluck('title')->first();
        });

        $mylists=Mylist::where('user_id', $user->id)->with('item')->get();
        $mylistItems = $mylists->pluck('item')->filter(function ($item) use ($expectedItems) {
            return $expectedItems->pluck('id')->contains($item->id);
        });

        $response=$this->get('/item/search?tab=mylist&keyword=' . $keyword);
        $response->assertStatus(200);

        $response->assertViewHas('items', function ($items) use ($mylistItems) {
            $titles = $items->pluck('item.title')->toArray();
            return $items->count() === $mylistItems->count() && $titles === $mylistItems->pluck('title')->toArray();
        });
    }
}
