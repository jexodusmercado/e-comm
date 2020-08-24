<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'seller_id','product_name','product_description','product_price','product_quantity','product_photo'
    ];

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
