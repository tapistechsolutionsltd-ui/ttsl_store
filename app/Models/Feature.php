<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feature extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'status', 'sort_order'];

    protected $casts = [
        'price'  => 'decimal:2',
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($feature) {
            if (empty($feature->slug)) {
                $feature->slug = Str::slug($feature->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'K ' . number_format($this->price, 2);
    }
}
