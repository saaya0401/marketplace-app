<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Mylist;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Purchase;

class ItemController extends Controller
{
    public function index(Request $request){
        $user_id=Auth::id();
        $tab=$request->query('tab');
        $purchaseItemIds=Purchase::pluck('item_id')->toArray();
        if($tab==='mylist'){
            $items=Mylist::where('user_id', $user_id)->whereHas('item', function($query) use ($user_id) {
                $query->where('user_id', '!=', $user_id);
            })->with('item')->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->get();
        }
        return view('index', compact('items', 'tab', 'purchaseItemIds'));
    }

    public function search(Request $request){
        $user_id=Auth::id();
        $tab=$request->query('tab');
        if($tab === 'mylist'){
            $items=Mylist::where('user_id', $user_id)->whereHas('item', function ($query) use ($user_id) {
                $query->where('user_id', '!=', $user_id);
            })->with('categories')->KeywordSearch($request->keyword)->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->with('categories')->KeywordSearch($request->keyword)->get();
        }
        return view('index', compact('items', 'tab'));
    }

    public function mypage(Request $request){
        $user_id=Auth::id();
        $profile=Profile::where('user_id', $user_id)->first();
        $tab=$request->query('tab');
        if($tab==='buy'){
            $items=Purchase::where('profile_id', $profile->id)->with('item')->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->get();
        }
        return view('mypage', compact('tab', 'profile', 'items'));
    }

    public function detail($itemId){
        $item=Item::find($itemId);
        $user_id=Auth::id();
        $categories=Category::all();
        $isMylisted=Mylist::where('item_id', $itemId)->where('user_id', $user_id)->exists();
        $mylistCount=Mylist::where('item_id', $itemId)->count();
        $commentCount=Comment::where('item_id', $itemId)->count();
        $comments=Comment::with(['profile.user'])->where('item_id', $itemId)->get();
        return view('detail', compact('item', 'categories', 'isMylisted', 'mylistCount', 'commentCount', 'comments'));
    }

    public function purchaseView($itemId){
        $item=Item::find($itemId);
        $user_id=Auth::id();
        $profile=Profile::where('user_id', $user_id)->first();
        return view('purchase', compact('item', 'profile'));
    }

    public function purchase(PurchaseRequest $request, $itemId){
        $item=Item::find($itemId);
        $user_id=Auth::id();
        $profile=Profile::where('user_id', $user_id)->first();
        $payment_method=$request->input('payment_method');
        $purchase=Purchase::create([
            'profile_id'=>$profile->id,
            'item_id'=>$itemId,
            'payment_method'=>$payment_method
        ]);
        return redirect('/');
    }

    public function comment(CommentRequest $request, $itemId){
        $user_id=Auth::id();
        $profile=Profile::where('user_id', $user_id)->first();
        $comment=Comment::create([
            'item_id'=>$itemId,
            'profile_id'=>$profile->id,
            'content'=>$request->input('content')
        ]);
        return redirect('/item/' . $itemId);
    }

    public function mylist(Request $request, $itemId){
        $user_id=Auth::id();
        $mylist=Mylist::where('item_id', $itemId)->where('user_id', $user_id)->first();
        if($mylist){
            $mylist->delete();
        }else{
            Mylist::create([
                'item_id'=>$itemId,
                'user_id'=>$user_id
            ]);
        }
        return redirect('/item/' . $itemId);
    }
}
