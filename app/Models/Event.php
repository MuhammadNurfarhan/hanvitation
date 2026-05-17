<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'wedding_id', 'type', 'venue_name', 'address', 'maps_link',
        'start_time', 'end_time', 'description', 'order'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function getTypeLabelAttribute()
    {
        return [
            'misa' => 'Misa Pernikahan',
            'resepsi' => 'Resepsi',
            'akad' => 'Akad Nikah',
            'ramah_tamah' => 'Ramah Tamah',
        ][$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getTypeColorAttribute(): string
    {
        return [
            'misa' => 'red',
            'resepsi' => 'amber',
            'akad' => 'pink',
            'ramah_tamah' => 'green',
        ][$this->type] ?? 'stone';
    }

    public function getTypeIconAttribute(): string
    {
        return [
            'misa' => '<svg class="w-7 h-7 text-white" fill="pink" viewBox="0 0 24 24"><path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7V2z"/></svg>',
            'resepsi' => '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>',
            'akad' => '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
            'ramah_tamah' => '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        ][$this->type] ?? '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }
}
