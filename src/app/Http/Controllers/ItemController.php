<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Mylist;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\Condition;
use App\Models\TransactionMessage;
use App\Models\Rating;

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
        $purchaseItemIds=Purchase::pluck('item_id')->toArray();
        if($tab === 'mylist'){
            $items=Mylist::where('user_id', $user_id)->whereHas('item', function ($query) use ($user_id,) {
                $query->where('user_id', '!=', $user_id);
            })->KeywordSearch($request->keyword)->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->KeywordSearch($request->keyword)->get();
        }
        return view('index', compact('items', 'tab', 'purchaseItemIds'));
    }

    public function mypage(Request $request){
        $user=Auth::user();
        $profile=Profile::where('user_id', $user->id)->first();
        $averageRating=round($user->receivedRatings()->avg('rating' ?? 0));
        $tab=$request->query('tab', 'sell');
        $purchases=collect();
        $ratingPurchaseIds=Rating::where('from_user_id', $user->id)->pluck('purchase_id')->toArray();
        if($tab ==='buy'){
            $purchases=Purchase::where('profile_id', $profile->id)->with('item', 'transactionMessages')->get();
            $items=$purchases;
        }elseif($tab === 'sell'){
            $items=Item::where('user_id', '=', $user->id)->get();
        }else{
            $buySide=Purchase::where('profile_id', $profile->id)->where('buyer_status', 'in_progress')->with(['item', 'transactionMessages'])->withCount([
                'transactionMessages as unreadCount'=>function ($query) use ($user){
                    $query->where('user_id', '!=', $user->id)->where('is_read', false);
                }
            ])->get();
            $sellItemIds=Item::where('user_id', $user->id)->pluck('id');
            $sellSide=Purchase::whereIn('item_id', $sellItemIds)->whereNotIn('id', $ratingPurchaseIds)->with(['item', 'transactionMessages'])->withCount([
                'transactionMessages as unreadCount'=>function($query) use ($user){
                    $query->where('user_id', '!=', $user->id)->where('is_read', false);
                }
            ])->get();
            $purchases=$buySide->merge($sellSide);
            $items=$purchases->sortByDesc(function ($purchase){
                return optional($purchase->transactionMessages->last())->created_at;
            })->values();
        }

        $status=Purchase::where('profile_id', $profile->id)->exists() ? 'buyer_status' : 'seller_status';
        $unreadCountAll=TransactionMessage::whereHas('purchase', function ($query) use ($status, $user, $profile){
            $query->where($status, 'in_progress')->where(function ($q) use ($user, $profile){
                $q->where('profile_id', $profile->id)->orWhereHas('item', function ($q2) use ($user){
                    $q2->where('user_id', $user->id);
                });
            });
        })->where('user_id', '!=', $user->id)->where('is_read', false)->count();
        return view('mypage', compact('tab', 'profile', 'items', 'averageRating', 'unreadCountAll'));
    }

    public function detail($itemId){
        $item=Item::find($itemId);
        $user_id=Auth::id();
        $categories=Category::all();
        $purchaseItemIds=Purchase::pluck('item_id')->toArray();
        $isMylisted=Mylist::where('item_id', $itemId)->where('user_id', $user_id)->exists();
        $mylistCount=Mylist::where('item_id', $itemId)->count();
        $commentCount=Comment::where('item_id', $itemId)->count();
        $comments=Comment::with(['profile.user'])->where('item_id', $itemId)->get();
        return view('detail', compact('item', 'categories', 'isMylisted', 'mylistCount', 'commentCount', 'comments', 'purchaseItemIds'));
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

    public function sellView(){
        $conditions=Condition::all();
        $categories=Category::all();
        return view('sell', compact('conditions', 'categories'));
    }

    public function sell(ExhibitionRequest $request){
        $exhibition=$request->only(['user_id', 'title', 'image', 'condition_id', 'price', 'description']);
        $item=Item::create($exhibition);
        $item->categories()->attach($request->categories);
        return redirect('/');
    }
}
