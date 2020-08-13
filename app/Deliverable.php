<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    protected $fillable = [
        'status', 'id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function auction(){
        return $this->hasOne(Auction::class, 'product_id', 'product_id');
    }

}
