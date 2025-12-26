<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersItems extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        // 'id',
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',

    ];

    // علاقة N:1 مع Orders
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    // علاقة N:1 مع Products
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
