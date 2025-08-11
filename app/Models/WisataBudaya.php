<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WisataBudaya extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'wisata_budaya';

    protected $fillable = [
        'nama_wisata',
        'deskripsi',
        'kategori',
        'lokasi',
        'jam_operasional',
        'harga_tiket',
        'kontak_person',
        'status_aktif',
    ];

    protected $casts = [
        'harga_tiket' => 'decimal:2',
        'status_aktif' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_utama')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('galeri')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->sharpen(10);
    }

    public function getFotoUtamaAttribute()
    {
        return $this->getFirstMediaUrl('foto_utama');
    }

    public function getFotoUtamaThumbAttribute()
    {
        return $this->getFirstMediaUrl('foto_utama', 'thumb');
    }
}
