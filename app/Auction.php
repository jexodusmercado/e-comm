<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'product_id', 'seller_id', 'offer_amount', 'shipping_amount'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function deliverable(){
        return $this->belongsTo(Deliverable::class,'product_id','product_id');
    }
}
