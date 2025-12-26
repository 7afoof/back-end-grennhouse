<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sellerReview extends Model
{
    protected $table = 'seller_reviews';

    protected $fillable = [
        'user_id',
        'seller_id',
        'rating',
        'comment',
    ];


    public function user()
    {
        return $this->belongsTo(UsersGreenHouse::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }

}
