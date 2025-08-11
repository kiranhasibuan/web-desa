<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfilDesa extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'profil_desa';
    protected $guarded = ['id'];

    protected $casts = [
        'koordinat_polygon' => 'array',
        'luas_wilayah' => 'decimal:2',
        'persen_luas_kec' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function strukturPemerintahan()
    {
        return $this->hasMany(StrukturPemerintahan::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_kepdes')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->quality(90)
            ->fit(Fit::Crop, 200, 200)
            ->nonQueued()
            ->performOnCollections('foto_kepdes');

        $this->addMediaConversion('medium')
            ->format('webp')
            ->quality(90)
            ->fit(Fit::Crop, 400, 400)
            ->nonQueued()
            ->performOnCollections('foto_kepdes');

        $this->addMediaConversion('large')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Crop, 800, 800)
            ->nonQueued()
            ->performOnCollections('foto_kepdes');
    }

    public function getFotoKepdesImageUrl($conversion = 'large')
    {
        return $this->getFirstMediaUrl('foto_kepdes', $conversion);
    }

    public function scopeSambutanKepdes($query)
    {
        return $query->whereNotNull('sambutan_kepdes');
    }

    public function scopeHasFotoKepdes($query)
    {
        return $query->whereHas('media', function ($q) {
            $q->where('collection_name', 'foto_kepdes');
        });
    }

    // Mutator untuk koordinat polygon
    public function setKoordinatPolygonAttribute($value)
    {
        $this->attributes['koordinat_polygon'] = is_string($value) ? $value : json_encode($value);
    }
}
