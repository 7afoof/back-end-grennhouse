<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGreenHouse extends Model
{
    protected $table = 'usersgreenhouse';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // user عندو seller واحد
    public function seller()
    {
        return $this->hasOne(Sellers::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(SellerReview::class, 'user_id');
    }

}