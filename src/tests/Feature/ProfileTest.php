<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testProfile(){
        $user=User::where('email', 'koharu@example.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user);
        $profile=Profile::where('user_id', $user->id)->first();

        $purchases=Purchase::where('profile_id', $profile)->get();
        $response=$this->get('/mypage');
        $response->assertStatus(200);
        if($profile->profile_image){
            $response->assertSee($profile->profile_image);
        }
        $response->assertSee($user->name);

        $response=$this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        foreach($purchases as $purchase){
            $response->assertSee($purchase->item->image);
            $response->assertSee($purchase->item->title);
        }

        $response=$this->get('/mypage?tab=sell');
        $response->assertStatus(200);
        $items=Item::where('user_id', $user->id)->get();
        foreach($items as $item){
            $response->assertSee($item->image);
            $response->assertSee($item->title);
        }
    }
}
