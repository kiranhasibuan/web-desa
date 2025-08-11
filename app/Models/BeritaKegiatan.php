<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class BeritaKegiatan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'berita_kegiatan';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'penulis',
        'tanggal_publikasi',
        'status_publikasi',
        'jumlah_views',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'jumlah_views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_utama')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('galeri_berita')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('featured')
            ->width(1200)
            ->height(800)
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
