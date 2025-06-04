<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['user_id', 'condition_id', 'title', 'description', 'image', 'price'];

    public function getFormattedPriceAttribute(){
        return number_format($this->price);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)){
            $query->where('title', 'like', '%' . $keyword . '%');
        }
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }
}
