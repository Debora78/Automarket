<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'car_id'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
