<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function deliverable(){
        return $this->belongsTo(Deliverable::class,'product_id','product_id');
    }
}
