<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Country extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = ['country_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_name',
        'country_code',
    ];

    /**
     * Get the profiles for this country.
     */
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Register media collections for flag images.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('flag-images')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
            ->useDisk('public');
    }

    /**
     * Register media conversions for flag images.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(32)
            ->height(32)
            ->sharpen(10)
            ->performOnCollections('flag-images')
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(64)
            ->height(64)
            ->sharpen(10)
            ->performOnCollections('flag-images')
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(128)
            ->height(128)
            ->sharpen(10)
            ->performOnCollections('flag-images')
            ->nonQueued();
    }

    /**
     * Get the flag image URL.
     */
    public function getFlagImageUrl($conversion = null): ?string
    {
        $flagImage = $this->getFirstMedia('flag-images');
        
        if (!$flagImage) {
            return null;
        }
        
        return $conversion ? $flagImage->getUrl($conversion) : $flagImage->getUrl();
    }

    /**
     * Get the flag image as thumbnail.
     */
    public function getFlagImageThumbUrl(): ?string
    {
        return $this->getFlagImageUrl('medium');
    }

    /**
     * Check if country has a flag image.
     */
    public function hasFlagImage(): bool
    {
        return $this->getMedia('flag-images')->count() > 0;
    }
}
