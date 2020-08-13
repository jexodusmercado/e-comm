<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction_line extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
    return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
