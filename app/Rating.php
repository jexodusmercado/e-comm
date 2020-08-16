<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'product_id','buyer_id','seller_id','rating','comment'
    ];

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id' , 'id');
    }

    public function seller(){
        return $this->belongsTo(User::class);
    }

    public function Deliverable(){
        return $this->belongsTo(Deliverable::class, 'product_id', 'product_id');
    }
}
