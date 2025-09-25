<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Profile extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = ['display_name', 'about'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'gender',
        'display_name',
        'age',
        'city',
        'address',
        'about',
        'availability_hours',
        'verified_at',
        'status',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'availability_hours' => 'array',
            'verified_at' => 'datetime',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include public profiles.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include approved profiles.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include verified profiles.
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    /**
     * Check if the profile is verified.
     */
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    /**
     * Check if the profile is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Mark the profile as verified.
     */
    public function markAsVerified(): static
    {
        $this->verified_at = now();
        $this->save();

        return $this;
    }

    /**
     * Mark the profile as unverified.
     */
    public function markAsUnverified(): static
    {
        $this->verified_at = null;
        $this->save();

        return $this;
    }

    /**
     * Check if the profile belongs to a woman.
     */
    public function isWoman(): bool
    {
        return $this->gender === 'female';
    }

    /**
     * Check if the profile belongs to a man.
     */
    public function isMan(): bool
    {
        return $this->gender === 'male';
    }

    /**
     * Register media collections for profile images.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->useDisk('public');
    }

    /**
     * Register media conversions for different image sizes.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('profile-images');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->sharpen(10)
            ->performOnCollections('profile-images');
    }

    /**
     * Get the first profile image URL.
     */
    public function getFirstImageUrl($conversion = null): ?string
    {
        $firstImage = $this->getFirstMedia('profile-images');
        
        if (!$firstImage) {
            return null;
        }
        
        return $conversion ? $firstImage->getUrl($conversion) : $firstImage->getUrl();
    }

    /**
     * Get the first profile image as thumbnail.
     */
    public function getFirstImageThumbUrl(): ?string
    {
        return $this->getFirstImageUrl('thumb');
    }

    /**
     * Get all profile images.
     */
    public function getAllImages()
    {
        return $this->getMedia('profile-images');
    }

    /**
     * Check if profile has multiple images.
     */
    public function hasMultipleImages(): bool
    {
        return $this->getMedia('profile-images')->count() > 1;
    }
}
