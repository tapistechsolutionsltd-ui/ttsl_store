<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CppPromotion extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'description', 'instructions', 'banner_image',
        'start_date', 'expiry_date', 'max_clients', 'status',
        'enable_portal', 'allow_search', 'show_client_counter', 'show_remaining_slots',
        'show_timeline', 'auto_close', 'auto_expire', 'display_on_homepage', 'code_prefix',
    ];

    protected $casts = [
        'instructions'          => 'array',
        'start_date'            => 'date',
        'expiry_date'           => 'datetime',
        'max_clients'           => 'integer',
        'enable_portal'         => 'boolean',
        'allow_search'          => 'boolean',
        'show_client_counter'   => 'boolean',
        'show_remaining_slots'  => 'boolean',
        'show_timeline'         => 'boolean',
        'auto_close'            => 'boolean',
        'auto_expire'           => 'boolean',
        'display_on_homepage'   => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($promotion) {
            if (empty($promotion->slug)) {
                $promotion->slug = Str::slug($promotion->title) . '-' . Str::random(4);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'cpp_promotion_id');
    }

    public function clients()
    {
        return $this->hasMany(CppClient::class);
    }

    public function codes()
    {
        return $this->hasMany(CppCode::class);
    }

    public function scopePortalEnabled($query)
    {
        return $query->where('enable_portal', true);
    }

    public function registeredCount(): int
    {
        return $this->clients()->count();
    }

    public function remainingSlots(): ?int
    {
        if ($this->max_clients === null) {
            return null;
        }
        return max(0, $this->max_clients - $this->registeredCount());
    }

    public function isFull(): bool
    {
        return $this->max_clients !== null && $this->registeredCount() >= $this->max_clients;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date !== null && $this->expiry_date->isPast();
    }

    public function getEffectiveStatusAttribute(): string
    {
        if (in_array($this->status, ['draft', 'closed'], true)) {
            return $this->status;
        }
        if ($this->auto_expire && $this->isExpired()) {
            return 'expired';
        }
        if ($this->auto_close && $this->isFull()) {
            return 'closed';
        }
        return $this->status;
    }

    public function isOpenForRegistration(): bool
    {
        return $this->getEffectiveStatusAttribute() === 'published';
    }
}
