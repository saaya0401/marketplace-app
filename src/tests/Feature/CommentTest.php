<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Profile;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $item;
    protected $profile;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($this->user);

        $this->actingAs($this->user);

        $this->profile=Profile::where('user_id', $this->user->id)->first();
        $this->item=Item::where('id', 1)->first();
    }

    public function testCommentLoginUser(){
        $beforeCount=Comment::where('item_id', $this->item->id)->count();

        $response=$this->post(url('/comment/' . $this->item->id), [
            'item_id'=>$this->item->id,
            'profile_id'=>$this->profile->id,
            'content'=>'コメント'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(url('/item/' . $this->item->id));

        $afterCount=Comment::where('item_id', $this->item->id)->count();
        $this->assertEquals($beforeCount + 1, $afterCount);

        $this->assertDatabaseHas('comments', [
            'profile_id'=>$this->profile->id,
            'item_id'=>$this->item->id,
            'content'=>'コメント'
        ]);
    }

    public function testCommentGuestUser(){
        auth()->logout();

        $response=$this->post(url('/comment/' . $this->item->id), [
            'item_id'=>$this->item->id,
            'profile_id'=>$this->profile->id,
            'content'=>'コメント'
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id'=>$this->item->id,
            'profile_id'=>$this->profile->id,
            'content'=>'コメント'
        ]);
    }

    public function testCommentEmpty(){
        $response=$this->post(url('/comment/' . $this->item->id), [
            'item_id'=>$this->item->id,
            'profile_id'=>$this->profile->id,
            'content'=>''
        ]);
        $response->assertSessionHasErrors(['content'=>'商品コメントを入力してください']);
    }

    public function testCommentMax(){
        $content=str_repeat('あ', 260);
        $response=$this->post(url('/comment/' . $this->item->id), [
            'item_id'=>$this->item->id,
            'profile_id'=>$this->profile->id,
            'content'=>$content
        ]);
        $response->assertSessionHasErrors(['content'=>'商品コメントは255文字以下で入力してください']);
    }
}
