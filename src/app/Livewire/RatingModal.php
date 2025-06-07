<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseCompleted;

class RatingModal extends Component
{
    public Item $item;
    public $showModal=false;
    public int $rating=3;

    public function mount(Item $item){
        $this->item=$item;
        $this->rating=3;
        if(Auth::id() === $item->user_id && $item->purchase && $item->purchase->buyer_status === 'completed' ){
            $this->showModal=true;
        }
    }

    public function openModal(){
        $this->showModal=true;
    }

    public function setRating($value){
        $this->rating=$value;
    }

    public function submitRating(){
        $user=Auth::user();
        $purchase=$this->item->purchase;
        $formUserId=$user->id;

        if($this->item->user_id ===$user->id){
            $toUserId=$purchase->profile->user_id;
        }else{
            $toUserId=$this->item->user_id;
        }

        Rating::create([
            'purchase_id'=>$purchase->id,
            'from_user_id'=>$formUserId,
            'to_user_id'=>$toUserId,
            'rating'=>$this->rating
        ]);

        $seller=$this->item->user;
        if($user->id === $seller->id){
            $purchase->update(['seller_status'=>'completed']);
        }else{
            $purchase->update(['buyer_status'=>'completed']);
        }

        if($seller !== $user){
            Mail::to($seller->email)->send(new PurchaseCompleted($this->item));
        }
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.rating-modal');
    }
}
