<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProdukUnggulan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'produk_unggulan';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'kategori',
        'harga_min',
        'harga_max',
        'satuan',
        'produsen',
        'kontak_produsen',
        'status_tersedia',
    ];

    protected $casts = [
        'harga_min' => 'decimal:2',
        'harga_max' => 'decimal:2',
        'status_tersedia' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_produk')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('galeri_produk')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->sharpen(10)
            ->performOnCollections('foto_produk', 'galeri_produk')
            ->nonQueued(); // Langsung generate agar muncul di Media Manager

        $this->addMediaConversion('preview')
            ->width(600)
            ->height(600)
            ->sharpen(10)
            ->performOnCollections('foto_produk', 'galeri_produk')
            ->nonQueued();
    }

    /**
     * Get the product photo URL
     * @param string $conversion
     * @return string|null
     */
    public function getFotoProdukUrl(string $conversion = ''): ?string
    {
        $media = $this->getFirstMedia('foto_produk');

        if (!$media) {
            return null;
        }

        return $conversion ? $media->getUrl($conversion) : $media->getUrl();
    }

    /**
     * Get the gallery image URL
     * @param string $conversion
     * @return string|null
     */
    public function getGaleriProdukUrl(string $conversion = ''): ?string
    {
        $media = $this->getFirstMedia('galeri_produk');

        if (!$media) {
            return null;
        }

        return $conversion ? $media->getUrl($conversion) : $media->getUrl();
    }

    /**
     * Get all gallery images URLs
     * @param string $conversion
     * @return array
     */
    public function getAllGaleriUrls(string $conversion = ''): array
    {
        return $this->getMedia('galeri_produk')
            ->map(function ($media) use ($conversion) {
                return $conversion ? $media->getUrl($conversion) : $media->getUrl();
            })
            ->toArray();
    }

    /**
     * Check if the banner has an image
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->hasMedia('foto_produk');
    }

    public function getFotoProdukAttribute()
    {
        return $this->getFirstMediaUrl('foto_produk');
    }

    public function getFotoProdukThumbAttribute()
    {
        return $this->getFirstMediaUrl('foto_produk', 'thumb');
    }
}
