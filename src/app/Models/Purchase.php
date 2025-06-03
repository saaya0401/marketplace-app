<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable=['profile_id', 'item_id', 'payment_method', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function transactionMessages(){
        return $this->hasMany(TransactionMessage::class);
    }
}
