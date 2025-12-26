<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        // 'id',
        'user_id',
        'seller_id',
        'firstNameCustomer',
        'lastNameCustomer',
        'phoneCustomer',
        'adressCustomer',
        'total_amount',
        'status',
    ];
    // علاقة N:1 مع User
    public function user()
    {
        return $this->belongsTo(UsersGreenHouse::class, 'user_id');
    }

    // علاقة N:1 مع Seller
    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }

    // علاقة 1:N مع OrderItems (لو كاين جدول order_items)
    public function orderItems()
    {
        return $this->hasMany(OrdersItems::class, 'order_id');
    }
}
