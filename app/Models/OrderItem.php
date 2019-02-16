<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['amount', 'price', 'rating', 'review', 'reviewed_at', 'product_id'];
    protected $dates = ['reviewed_at'];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
