<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'shipping_address', 'subtotal',
        'shipping', 'discount', 'tax', 'total', 'payment_method',
        'payment_status', 'order_status', 'notes', 'admin_notes', 'tracking_number',
        'attachment_path', 'attachment_original_name', 'development_due_date',
        'client_email', 'organisation', 'existing_domain', 'is_first_website',
        'website_type', 'preferred_colors', 'social_media_links',
    ];

    protected $casts = [
        'user_id'            => 'integer',
        'shipping_address'   => 'array',
        'subtotal'           => 'decimal:2',
        'shipping'           => 'decimal:2',
        'discount'           => 'decimal:2',
        'tax'                => 'decimal:2',
        'total'              => 'decimal:2',
        'development_due_date' => 'date',
        'is_first_website'     => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cppClients()
    {
        return $this->hasMany(CppClient::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'pending'    => 'Pending',
            'processing' => 'In Development',
            'paid'       => 'Payment Confirmed',
            'shipped'    => 'In Progress',
            'delivered'  => 'Project Completed',
            'cancelled'  => 'Cancelled',
            'refunded'   => 'Refunded',
            default      => ucfirst($this->order_status),
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'bank_transfer'    => 'Bank Transfer',
            'cash_on_delivery' => 'Cash on Completion',
            default            => ucwords(str_replace('_', ' ', $this->payment_method ?? '')),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->order_status) {
            'pending'    => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'paid'       => 'bg-green-100 text-green-800',
            'shipped'    => 'bg-indigo-100 text-indigo-800',
            'delivered'  => 'bg-green-200 text-green-900',
            'cancelled'  => 'bg-red-100 text-red-800',
            'refunded'   => 'bg-gray-100 text-gray-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            'paid'     => 'bg-green-100 text-green-800',
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'failed'   => 'bg-red-100 text-red-800',
            'refunded' => 'bg-gray-100 text-gray-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'TTSL-' . strtoupper(date('Ymd')) . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'K ' . number_format($this->total, 2);
    }

    public function getDevelopmentProgressAttribute(): array
    {
        if (!$this->development_due_date) {
            return ['has_timeline' => false];
        }

        $start     = $this->created_at->startOfDay();
        $end       = $this->development_due_date;
        $now       = now()->startOfDay();
        $totalDays = max(1, $start->diffInDays($end));
        $elapsed   = min($totalDays, max(0, $start->diffInDays($now)));
        $remaining = max(0, $now->diffInDays($end, false));
        $percent   = min(100, (int) round(($elapsed / $totalDays) * 100));
        $isOverdue = $now->greaterThan($end) && !in_array($this->order_status, ['delivered', 'cancelled', 'refunded']);

        return [
            'has_timeline' => true,
            'total_days'   => $totalDays,
            'elapsed'      => $elapsed,
            'remaining'    => $remaining,
            'percent'      => $percent,
            'due_date'     => $end->format('d M Y'),
            'is_overdue'   => $isOverdue,
            'is_complete'  => in_array($this->order_status, ['delivered']),
        ];
    }
}
