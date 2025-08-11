<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Banner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'banner';

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'aktif',
        'urutan'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Define media conversions untuk banner
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail kecil untuk admin panel
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Crop, 300, 142)  // Gunakan fit() dengan Fit::Crop
            ->nonQueued();

        // Banner ukuran medium untuk mobile
        $this->addMediaConversion('medium')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Crop, 1200, 567)  // Gunakan fit() dengan Fit::Crop
            ->nonQueued();

        // Banner ukuran penuh untuk desktop
        $this->addMediaConversion('large')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Crop, 1720, 810)  // Gunakan fit() dengan Fit::Crop
            ->nonQueued();
    }

    /**
     * Define media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    /**
     * Scope untuk banner aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true); // bukan 'aktive'
    }
    /**
     * Scope untuk mengurutkan banner
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    /**
     * Helper method untuk mendapatkan URL gambar banner
     */
    public function getBannerImageUrl($conversion = 'large')
    {
        return $this->getFirstMediaUrl('banner', $conversion);
    }

    /**
     * Helper method untuk mengecek apakah banner memiliki gambar
     */
    public function hasBannerImage()
    {
        return $this->hasMedia('banner');
    }
}
