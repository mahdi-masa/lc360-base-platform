<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = [
        'sent_at',
        'expires_at',
        'verified_at',
    ];

    protected $fillable = [
        'code',
        'phone',
        'expires_at',
        'sent_at',
        'verified_at',
    ];

    public function scopeNotVerified($query)
    {
        return $query->whereNull('verified_at');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>=', now());
    }

    public function scopeSentToday($query)
    {
        return $query->whereDate('sent_at', today());
    }
}
