<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;
use Stripe\Checkout\Session;
use Stripe\Product;
use Stripe\Price;
use Stripe\Stripe;
use Illuminate\Support\Facades\Config;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $item;
    protected $profile;
    protected $session;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user=User::where('email', 'saaya@example.com')->first();
        $this->assertNotNull($this->user);

        $this->actingAs($this->user);

        $this->profile=Profile::where('user_id', $this->user->id)->first();
        $this->item=Item::where('id', 1)->first();

        Stripe::setApiKey(Config::get('services.stripe.secret'));

        $product = Product::create([
            'name' => $this->item->title,
            'description' => '商品説明',
        ]);

        $price = Price::create([
            'unit_amount' => $this->item->price,
            'currency' => 'jpy',
            'product' => $product->id,
        ]);

        $this->session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $price->id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => url('/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/purchase/' . $this->item->id),
        ]);
    }

    public function testPurchase(){
        $response = $this->post(url('/purchase/' . $this->item->id . '/stripe'), [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method' => 'カード払い'
        ]);

        Purchase::create([
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);

        $this->assertDatabaseHas('purchases', [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);
    }

    public function testPurchaseSold(){
        $response = $this->post(url('/purchase/' . $this->item->id . '/stripe'), [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method' => 'カード払い'
        ]);

        Purchase::create([
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);

        $this->assertDatabaseHas('purchases', [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);

        $response = $this->get(url('/success?session_id=' . $this->session->id . '&item_id=' . $this->item->id));
        $response->assertRedirect('/');
        $response=$this->get('/');
        $response->assertSee('Sold');
    }

    public function testPurchaseProfile(){
        $response = $this->post(url('/purchase/' . $this->item->id . '/stripe'), [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method' => 'カード払い'
        ]);

        Purchase::create([
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);

        $this->assertDatabaseHas('purchases', [
            'profile_id' => $this->profile->id,
            'item_id' => $this->item->id,
            'payment_method'=>'カード払い'
        ]);

        $response=$this->get(url('/success?session_id=' . $this->session->id . '&item_id=' . $this->item->id));
        $response->assertRedirect('/');

        $response=$this->get('/mypage?tab=buy');
        $response->assertStatus(200);

        $response->assertSee($this->item->title);
        $response->assertSee($this->item->image);
    }
}
