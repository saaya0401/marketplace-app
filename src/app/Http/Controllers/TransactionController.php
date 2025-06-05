<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\TransactionMessage;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function chatView($itemId){
        $item=Item::find($itemId);
        $user=Auth::user();
        $self=$user->profile;
        $purchase=Purchase::where('item_id', $itemId)->first();
        $buyer=$purchase->profile;
        if($item->user_id === $user->id){
            $transactions=Purchase::whereIn('item_id', function ($query) use ($user){
                $query->select('id')->from('items')->where('user_id', $user->id);
            })->where('status', 'in_progress')->where('item_id', '!=', $itemId)->get();
        }else{
            $transactions=Purchase::where('profile_id', $self->id)->where('status', 'in_progress')->where('item_id', '!=', $itemId)->get();
        }
        $transactionMessages=TransactionMessage::where('purchase_id', $purchase->id)->orderBy('created_at', 'asc')->get();
        return view('transaction_chat', compact('item', 'self', 'buyer', 'transactions', 'transactionMessages'));
    }

    public function message(MessageRequest $request){
        $message=$request->only(['user_id', 'body', 'message_image', 'purchase_id']);
        TransactionMessage::create($message);
        $purchase=Purchase::find($message['purchase_id']);
        $itemId=$purchase->item_id;
        return redirect('/transaction/' . $itemId);
    }
}
