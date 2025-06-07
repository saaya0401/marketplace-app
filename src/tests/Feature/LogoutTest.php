<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLogout(){
        $response=$this->get('/login');
        $response->assertStatus(200);

        User::factory()->create([
            'email'=>'test@example.com',
            'password'=>bcrypt('password123')
        ]);

        $response=$this->post('/login', [
            'email'=>'test@example.com',
            'password'=>'password123',
            '_token'=>csrf_token(),
        ]);

        $user=User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        $this->assertTrue(auth()->attempt([
            'email'=>'test@example.com',
            'password'=>'password123'
        ]));
        $response->assertRedirect('/');

        $response=$this->withoutMiddleware()->post('/logout');
        $this->assertFalse(auth()->check());
        $response->assertRedirect('/');
    }
}
