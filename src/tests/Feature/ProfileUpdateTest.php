<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testProfileUpdate(){
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user);
        $profile=Profile::where('user_id', $user->id)->first();

        $response=$this->get('/mypage/profile');
        $response->assertSee($user->name);
        $response->assertSee($profile->postal_code);
        $response->assertSee($profile->address);
        if($profile->profile_image){
            $response->assertSee($profile->profile_image);
        }
        if($profile->building){
            $response->assertSee($profile->building);
        }
    }
}
