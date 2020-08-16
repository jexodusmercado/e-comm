<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction_line extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
    return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function rating(){
        return $this->hasMany(Rating::class,'seller_id','seller_id');
    }

    public function averageRate(){
        return round($this->rating->avg('sum'));
    }

}
