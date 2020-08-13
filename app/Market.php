<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = [
        'product_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
