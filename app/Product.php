<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'imageFront', 'imageBack', 'userId', 'asset_image', 'XXS', 'XSM',
        'SML', 'MED', 'LRG', 'XLG', 'XXL', 'selectedProduct', 'totalQty'
    ];

    public function market(){
        return $this->hasOne(Market::class);
    }

    public function auction_line(){
        return $this->hasMany(Auction_line::class);
    }

    public function auction(){
        return $this->hasOne(Auction::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function deliverable(){
        return $this->hasOne(Deliverable::class, 'product_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function Rating(){
        return $this->hasMany(Rating::class);
    }

}
