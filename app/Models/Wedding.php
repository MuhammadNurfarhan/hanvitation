<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Wedding extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'title', 'groom_name', 'groom_first_name', 'groom_father_name',
        'groom_mother_name', 'groom_photo', 'groom_instagram', 'groom_instagram_handle',
        'bride_name', 'bride_first_name', 'bride_father_name', 'bride_mother_name',
        'bride_photo', 'bride_instagram', 'bride_instagram_handle',
        'event_date', 'quote', 'quote_source', 'greeting_message',
        'cover_image', 'envelope_image', 'groom_photo', 'bride_photo', 'music_file', 'qr_code', 'is_published', 'published_at'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wedding) {
            if (empty($wedding->slug)) {
                $wedding->slug = Str::slug($wedding->groom_first_name . '-' . $wedding->bride_first_name) . '-' . Str::random(5);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class)->orderBy('order');
    }

    public function churchEvent(): HasOne
    {
        return $this->hasOne(Event::class)->where('type', 'misa');
    }

    public function receptionEvent(): HasOne
    {
        return $this->hasOne(Event::class)->where('type', 'resepsi');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('order');
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class)->orderBy('order');
    }

    public function guestMessages(): HasMany
    {
        return $this->hasMany(GuestMessage::class)->where('is_approved', true)->latest();
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : asset('images/default-cover.jpg');
    }

    public function getInvitationUrlAttribute()
    {
        return url('/' . $this->slug);
    }
}
