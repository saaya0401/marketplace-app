<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Mylist;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Comment;

class ItemController extends Controller
{
    public function index(Request $request){
        $user_id=Auth::id();
        $tab=$request->query('tab');
        if($tab==='mylist'){
            $items=Mylist::where('user_id', $user_id)->whereHas('item', function($query) use ($user_id) {
                $query->where('user_id', '!=', $user_id);
            })->with('item')->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->get();
        }
        return view('index', compact('items', 'tab'));
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

    public function detail($itemId){
        $item=Item::find($itemId);
        $user_id=Auth::id();
        $categories=Category::all();
        $isMylisted=Mylist::where('item_id', $itemId)->where('user_id', $user_id)->exists();
        $mylistCount=Mylist::where('item_id', $itemId)->where('user_id', $user_id)->count();
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
