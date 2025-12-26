<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    protected $table = 'sellers';

    protected $fillable = [
        'user_id',
        'store_name',
        'phone',
        'logo',
        'banner',
        'city',
        'address',
        'subscription_type',
        'subscription_expires_at',
        'rating',
        'description'
    ];

    // seller تابع ل user
    public function user()
    {
        return $this->belongsTo(UsersGreenHouse::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(SellerReview::class, 'seller_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(SellerFeedback::class, 'seller_id');
    }
    public function products()
    {
        return $this->hasMany(Products::class, 'seller_id');
    }

}
