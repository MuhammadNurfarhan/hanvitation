<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'wedding_id', 'name', 'phone', 'email', 'unique_code',
        'status', 'guest_count', 'message', 'is_sent', 'sent_at'
    ];

    protected $casts = [
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            if (empty($guest->unique_code)) {
                $guest->unique_code = Str::random(8);
            }
        });
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function getInvitationUrlAttribute()
    {
        return url('/' . $this->wedding->slug . '?untuk=' . urlencode($this->name));
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Belum Konfirmasi',
            'hadir' => 'Hadir',
            'tidak_hadir' => 'Tidak Hadir',
            'ragu' => 'Ragu-ragu'
        ][$this->status];
    }
}
