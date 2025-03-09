<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;

class AddressTest extends TestCase
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

        $this->item=Item::where('id', 1)->first();
        $this->profile=Profile::where('user_id', $this->user->id)->first();
    }

    public function testAddress(){
        $updateData=[
            'user_id'=>$this->user->id,
            'postal_code'=>'111-1111',
            'address'=>'大阪府三島郡島本町',
            'building'=>'島本222'
        ];
        $response=$this->patch(url('/purchase/address/' . $this->item->id), $updateData);
        $response->assertStatus(302);
        $response->assertRedirect(url('/purchase/' . $this->item->id));
        $this->assertDatabaseHas('profiles', $updateData);

        $response=$this->get(url('/purchase/' . $this->item->id));
        $response->assertStatus(200);
        $response->assertSee('111-1111');
        $response->assertSee('大阪府三島郡島本町');
        $response->assertSee('島本222');
    }

    public function testAddressChangePurchase(){
        $updateAddress=[
            'user_id'=>$this->user->id,
            'postal_code'=>'111-1111',
            'address'=>'大阪府三島郡島本町',
            'building'=>'島本222'
        ];
        $response=$this->patch(url('/purchase/address/' . $this->item->id), $updateAddress);
        $response->assertStatus(302);
        $response->assertRedirect(url('/purchase/' . $this->item->id));
        $this->assertDatabaseHas('profiles', $updateAddress);

        $purchaseData = [
            'profile_id' => $this->user->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ];
        $response=$this->post(url('/purchase/' . $this->item->id . '/stripe'));
        Purchase::create($purchaseData);
        $this->assertDatabaseHas('purchases', $purchaseData);
    }
}
