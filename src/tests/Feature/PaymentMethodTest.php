<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Livewire\PurchaseForm;
use Livewire\Livewire;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testPaymentMethod(){
        $item=Item::where('id', 1)->first();
        $user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user);
        $profile=Profile::where('user_id', $user->id)->first();

        $response=$this->get(url('/purchase/' . $item->id));
        $response->assertStatus(200);

        Livewire::test(PurchaseForm::class, [
            'item'=>$item,
            'profile'=>$profile
        ])
            ->set('paymentMethod', 'カード払い')
            ->assertSet('paymentMethod', 'カード払い')
            ->assertSee('カード払い');
    }
}
