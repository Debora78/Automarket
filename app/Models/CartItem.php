<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['session_id', 'user_id', 'car_id', 'quantity'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
