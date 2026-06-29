<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'max_uses',
        'used_count', 'expires_at', 'status',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'status' => 'boolean',
        'value' => 'decimal:2',
    ];

    public function isValid(float $orderAmount): bool
    {
        if (!$this->status) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->min_order && $orderAmount < $this->min_order) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            return round($amount * ($this->value / 100), 2);
        }
        return min($this->value, $amount);
    }
}
