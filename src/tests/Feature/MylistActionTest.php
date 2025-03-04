<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Mylist;

class MylistActionTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($this->user);

        $this->actingAs($this->user);

        $this->item=Item::where('id', 1)->first();
    }

    public function testMylist(){
        $response=$this->get(url('/item/' . $this->item->id));
        $response->assertStatus(200);

        $beforeCount=Mylist::where('item_id', $this->item->id)->count();

        $response=$this->post(url('/mylist/' . $this->item->id));
        $response->assertStatus(302);
        $response->assertRedirect(url('/item/' . $this->item->id));

        $afterCount=Mylist::where('item_id', $this->item->id)->count();
        $this->assertEquals($beforeCount + 1, $afterCount);

    }

    public function testMylistIcon(){
        $response=$this->get(url('/item/' . $this->item->id));
        $response->assertStatus(200);

        $response->assertSee('src="http://localhost/icon/star.png"', false);

        $response=$this->post(url('/mylist/' . $this->item->id));
        $response->assertStatus(302);
        $response->assertRedirect(url('/item/' . $this->item->id));
        $response=$this->get(url('/item/' . $this->item->id));
        $response->assertStatus(200);

        $response->assertSee('src="http://localhost/icon/star-yellow.png"', false);
    }

    public function testMylistCancel(){
        Mylist::insert([
            'user_id'=>$this->user->id,
            'item_id'=>$this->item->id
        ]);
        $response=$this->get(url('/item/' . $this->item->id));
        $response->assertStatus(200);
        $response->assertSee('src="http://localhost/icon/star-yellow.png"', false);

        $beforeCount=Mylist::where('item_id', $this->item->id)->count();

        $response=$this->post(url('/mylist/' . $this->item->id));
        $response->assertStatus(302);
        $response->assertRedirect(url('/item/' . $this->item->id));
        $response=$this->get(url('/item/' . $this->item->id));
        $response->assertStatus(200);

        $afterCount=Mylist::where('item_id', $this->item->id)->count();
        $this->assertEquals($beforeCount - 1, $afterCount);
        $response->assertSee('src="http://localhost/icon/star.png"', false);
    }
}
