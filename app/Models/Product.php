<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity'
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
