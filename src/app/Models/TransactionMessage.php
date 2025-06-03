<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionMessage extends Model
{
    protected $fillable=['purchase_id', 'user_id', 'body', 'message_image', 'is_read'];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
