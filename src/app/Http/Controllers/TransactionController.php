<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function chatView($itemId){
        $item=Item::find($itemId);
        $self=Auth::user()->profile;
        $transactions=Purchase::where('profile_id', $self->id)->where('status', 'in_progress')->where('item_id', '!=', $itemId)->get();
        return view('transaction_chat', compact('item', 'self', 'transactions'));
    }
}
