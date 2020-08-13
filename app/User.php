<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role','verification_id_img','first_name', 'middle_name', 'last_name', 'address1', 'address2', 'barangay', 'city', 'province', 'mobile_number', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function auction_line(){
        return $this->hasMany(Auction_line::class, 'id', 'seller_id');
    }

    public function deliverable(){
        return $this->hasMany(Deliverable::class, 'id', 'seller_id');
    }
}
