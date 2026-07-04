<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CppTimelineLog extends Model
{
    protected $fillable = [
        'cpp_client_id', 'status', 'notes', 'progress_percent', 'created_by',
    ];

    protected $casts = [
        'progress_percent' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(CppClient::class, 'cpp_client_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return CppClient::TIMELINE_STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }
}
