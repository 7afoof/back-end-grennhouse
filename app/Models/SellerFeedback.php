<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerFeedback extends Model
{
    protected $table = 'seller_feedback';
    protected $fillable = [
        'seller_id',
        'rating',
        'message',
        'status',
        'name',

    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
