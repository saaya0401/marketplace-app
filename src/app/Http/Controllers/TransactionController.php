<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageEditRequest;
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

        TransactionMessage::where('purchase_id', $purchase->id)->where('user_id', '!=', $user->id)->where('is_read', false)->update(['is_read'=>true]);
        $transactions=Purchase::where('status', 'in_progress')->where('item_id', '!=', $itemId)->where(function($query) use ($user, $self){
            $query->whereIn('item_id', function ($q) use ($user, $self){
                $q->select('id')->from('items')->where('user_id', $user->id);
            })->orWhere('profile_id', $self->id);
        })->get();
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

    public function messageEdit(MessageEditRequest $request, $itemId){
        $message=$request->only(['edit_body', 'id']);
        TransactionMessage::find($message['id'])->update([
            'body'=>$message['edit_body'],
            'is_read'=>false
        ]);
        return redirect('/transaction/' . $itemId);
    }

    public function messageDelete(Request $request, $itemId){
        $messageId=$request->input('id');
        TransactionMessage::find($messageId)?->delete();
        return redirect('/transaction/' . $itemId);
    }

    public function complete($itemId){

    }
}
