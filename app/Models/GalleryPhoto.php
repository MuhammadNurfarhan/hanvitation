<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wedding_id',
        'url',
        'caption',
        'order',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the wedding that owns the photo.
     */
    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * ✅ Accessor: Menghasilkan URL lengkap untuk gambar.
     * Menggunakan asset('storage/...') agar IDE tidak error
     * dan path konsisten dengan storage:link.
     */
    public function getUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // Mengubah 'weddings/gallery/file.jpg' menjadi '/storage/weddings/gallery/file.jpg'
        return asset('storage/' . $value);
    }
}
