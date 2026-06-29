<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'badge_text',
        'badge_color',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'image_path',
        'bg_color',
        'text_color',
        'overlay_opacity',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->image_path
            && strtolower(pathinfo($this->image_path, PATHINFO_EXTENSION)) === 'mp4';
    }
}
