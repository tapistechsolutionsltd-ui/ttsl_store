<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id'];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class)->where('saved_for_later', false);
    }

    public function savedItems()
    {
        return $this->hasMany(CartItem::class)->where('saved_for_later', true);
    }

    public function allItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->price);
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}
