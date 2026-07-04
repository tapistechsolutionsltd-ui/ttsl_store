<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CppCode extends Model
{
    protected $fillable = [
        'cpp_client_id', 'cpp_promotion_id', 'code', 'generated_at', 'expires_at', 'status',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(CppClient::class, 'cpp_client_id');
    }

    public function promotion()
    {
        return $this->belongsTo(CppPromotion::class, 'cpp_promotion_id');
    }
}
