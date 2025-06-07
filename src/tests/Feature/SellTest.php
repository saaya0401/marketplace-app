<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSell(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user);

        $response=$this->get('/sell');
        $response->assertStatus(200);

        $categoryIds=Category::find([2,3])->pluck('id')->toArray();
        $itemData=[
            'user_id'=>$user->id,
            'condition_id'=>Condition::find(3)->id,
            'title'=>'メロン',
            'description'=>'食べ物ではありません',
            'image'=>'item-img/Love.png',
            'price'=>1000,
            'categories'=>$categoryIds,
            '_token'=>csrf_token(),
        ];

        $response=$this->post('/sell', $itemData);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('items', [
            'user_id'=>$user->id,
            'condition_id'=>Condition::find(3)->id,
            'title'=>'メロン',
            'description'=>'食べ物ではありません',
            'price'=>1000
        ]);
        $item=Item::where('title', 'メロン')->first();
        foreach($categoryIds as $categoryId){
            $this->assertDatabaseHas('category_item', [
                'item_id'=>$item->id,
                'category_id'=>$categoryId
            ]);
        }
    }
}
