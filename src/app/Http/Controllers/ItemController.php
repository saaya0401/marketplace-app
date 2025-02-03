<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mylist;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index(Request $request){
        $user_id=Auth::id();
        $tab=$request->query('tab');
        if($tab==='mylist'){
            $items=Mylist::where('user_id', $user_id)->whereHas('item', function($query) use ($user_id) {
                $query->where('user_id', '!=', $user_id);
            })->with('categories')->get();
        }else{
            $items=Item::where('user_id', '!=', $user_id)->with('categories')->get();
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
        $categories=Category::all();
        $selectedCategories=$item->categories->pluck('id')->toArray();
        return view('detail', compact('item', 'selectedCategories', 'categories'));
    }
}
