<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price', 'features', 'saved_for_later'];

    protected $casts = [
        'saved_for_later' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'K ' . number_format($this->total, 2);
    }
}
