<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function purchaseStripe(PurchaseRequest $request, $itemId)
    {
        $item=Item::find($itemId);
        $payment_method=$request->input('payment_method');

        Stripe::setApiKey(config('services.stripe.secret'));
        $session=Session::create([
            'payment_method_types'=>$payment_method === 'コンビニ払い' ? ['konbini'] : ['card'],
            'line_items'=>[[
                'price_data'=>[
                    'currency'=>'jpy',
                    'product_data'=>[
                        'name'=>$item->title,
                    ],
                    'unit_amount'=>$item->price
                ],
                'quantity'=>1,
            ]],
            'mode'=>'payment',
            'success_url' => url('/success?session_id={CHECKOUT_SESSION_ID}&item_id=' . $itemId),
            'cancel_url' => url('/cancel'),
            ]);
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $profile=Profile::where('user_id', Auth::id())->first();
        Stripe::setApiKey(config('services.stripe.secret'));
        $session_id=$request->query('session_id');

        $session=Session::retrieve($session_id);
        $payment_method = $session->payment_method_types[0];
        if($session->payment_status === 'paid'){
            Purchase::create([
                'profile_id'=>$profile->id,
                'item_id'=>$request->query('item_id'),
                'payment_method'=>$payment_method
            ]);
            return redirect('/')->with('message', '決済が成功しました');
        }else{
            return redirect('/')->with('error', '決済の確認ができませんでした');
        }
    }

    public function cancel()
    {
        return redirect('/')->with('error', '決済がキャンセルされました');
    }
}
