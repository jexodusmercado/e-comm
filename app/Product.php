<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'imageFront', 'imageBack', 'userId'
    ];
}
