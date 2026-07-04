<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'description',
        'specifications', 'price', 'sale_price', 'stock', 'featured',
        'meta_title', 'meta_description', 'status', 'development_duration',
        'preview_path', 'preview_entry',
        'cpp_enabled', 'cpp_promotion_id', 'cpp_badge_text', 'cpp_priority', 'cpp_description',
    ];

    protected $casts = [
        'specifications' => 'array',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cpp_enabled' => 'boolean',
        'cpp_priority' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function cppPromotion()
    {
        return $this->belongsTo(CppPromotion::class, 'cpp_promotion_id');
    }

    public function isCppEligible(): bool
    {
        return $this->cpp_enabled && $this->cppPromotion && $this->cppPromotion->isOpenForRegistration();
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->is_on_sale) return 0;
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getDevelopmentDaysAttribute(): int
    {
        $duration = $this->development_duration ?? '3 Weeks';
        preg_match('/(\d+)\s*(week|day|month)/i', $duration, $m);
        if (!$m) return 21;
        $num = (int) $m[1];
        return match (strtolower($m[2])) {
            'month' => $num * 30,
            'week'  => $num * 7,
            default => $num,
        };
    }

    public function getAvailabilityLabelAttribute(): string
    {
        if ($this->stock <= 0) return 'Unavailable';
        if ($this->stock <= 3) return 'Limited — ' . $this->stock . ' slot' . ($this->stock > 1 ? 's' : '') . ' left';
        return 'Available (' . $this->stock . ' license' . ($this->stock > 1 ? 's' : '') . ')';
    }

    public function getHasPreviewAttribute(): bool
    {
        return !empty($this->preview_path);
    }

    public function getPreviewUrlAttribute(): ?string
    {
        if (!$this->preview_path) return null;
        $entry = $this->preview_entry ?: 'index.html';
        return asset('storage/' . $this->preview_path . '/' . $entry);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        if ($primary) {
            return asset('storage/' . $primary->image);
        }
        $first = $this->images->first();
        if ($first) {
            return asset('storage/' . $first->image);
        }
        return asset('images/placeholder.png');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'K ' . number_format($this->price, 2);
    }

    public function getFormattedCurrentPriceAttribute(): string
    {
        return 'K ' . number_format($this->current_price, 2);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // Fall back to id lookup if no product found by slug (handles missing/null slugs)
        return $this->where('slug', $value)->first()
            ?? $this->where('id', $value)->firstOrFail();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
