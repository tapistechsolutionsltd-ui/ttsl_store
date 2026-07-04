<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CppClient extends Model
{
    public const TIMELINE_STATUSES = [
        'application_received' => 'Application Received',
        'verification'         => 'Verification',
        'project_approved'     => 'Project Approved',
        'planning'             => 'Planning',
        'ui_design'            => 'UI Design',
        'development'          => 'Development',
        'testing'              => 'Testing',
        'client_review'        => 'Client Review',
        'deployment'           => 'Deployment',
        'completed'            => 'Completed',
    ];

    protected $fillable = [
        'cpp_promotion_id', 'user_id', 'order_id', 'order_item_id', 'product_id',
        'company_name', 'current_timeline_status', 'progress_percent', 'is_active',
    ];

    protected $casts = [
        'progress_percent' => 'integer',
        'is_active'        => 'boolean',
    ];

    public function promotion()
    {
        return $this->belongsTo(CppPromotion::class, 'cpp_promotion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function codes()
    {
        return $this->hasMany(CppCode::class);
    }

    public function activeCode()
    {
        return $this->hasOne(CppCode::class)->where('status', 'active')->latestOfMany();
    }

    public function timelineLogs()
    {
        return $this->hasMany(CppTimelineLog::class)->orderBy('created_at');
    }

    public function getCurrentTimelineLabelAttribute(): string
    {
        return self::TIMELINE_STATUSES[$this->current_timeline_status] ?? ucfirst(str_replace('_', ' ', $this->current_timeline_status));
    }
}
