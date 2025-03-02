<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mylist extends Model
{
    protected $fillable=['user_id', 'item_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->whereHas('item', function ($query) use ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
            });
        }
    }
}
