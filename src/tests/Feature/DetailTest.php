<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Mylist;
use App\Models\Comment;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testDetail(){
        $item=Item::with(['user', 'categories', 'condition'])->first();

        $response=$this->get(url('/item/' . $item->id));
        $response->assertStatus(200)
                ->assertSee($item->image)
                ->assertSee($item->title)
                ->assertSee($item->user->name)
                ->assertSee($item->formatted_price)
                ->assertSee($item->description)
                ->assertSee($item->condition->condition);

        foreach($item->categories as $category){
            $response->assertSee($category->name);
        }

        $mylistCount=Mylist::where('item_id', $item->id)->count();
        $response->assertSee((string)$mylistCount);

        $comments=Comment::where('item_id', $item->id)->get();
        $commentCount=$comments->count();
        $response->assertSee((string)$commentCount);
        foreach($comments as $comment){
            $response->assertSee($comment->profile->user->name)
                    ->assertSee($comment->profile->profile_image)
                    ->assertSee($comment->content);
        }
    }

    public function testDetailCategories(){
        $item=Item::with('categories')->first();
        $response=$this->get(url('/item/' . $item->id));
        $response->assertStatus(200);

        foreach($item->categories as $category){
            $response->assertSee($category->name);
        }
    }
}
