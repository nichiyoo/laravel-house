<?php

namespace App\Models;

use App\Helpers\Distance;
use App\Enums\AmenityType;
use App\Enums\IntervalType;
use App\Enums\StatusType;
use App\Enums\VerificationType;
use App\Traits\HasImageUpload;
use App\Traits\HasMultipleImageUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Property extends Model
{
  /** @use HasFactory<\Database\Factories\PropertyFactory> */
  use HasFactory, HasImageUpload, HasMultipleImageUpload;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string>
   */
  protected $fillable = [
    'name',
    'city',
    'region',
    'zipcode',
    'address',
    'price',
    'capacity',
    'interval',
    'description',
    'latitude',
    'longitude',
    'backdrop',
    'images',
    'amenities',
    'verification',
  ];

  /**
   * The attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'images' => 'array',
      'latitude' => 'decimal:6',
      'longitude' => 'decimal:6',
      'interval' => IntervalType::class,
      'verification' => VerificationType::class,
      'amenities' => AsEnumCollection::of(AmenityType::class),
    ];
  }

  /**
   * get user avatar
   */
  protected function backdrop(): Attribute
  {
    $default = asset('images/property.jpg');
    return Attribute::make(
      get: fn() => $this->attributes['backdrop'] ?? $default
    );
  }

  /**
   * Scope a query to only include verified properties.
   */
  public function scopeVerified(Builder $query): Builder
  {
    return $query->where('verification', VerificationType::VERIFIED);
  }

  /**
   * Scope a query to only include unverified properties.
   */
  public function scopeUnverified(Builder $query): Builder
  {
    return $query->where('verification', VerificationType::UNVERIFIED);
  }

  /**
   * Get the owner that owns the property.
   */
  public function owner(): BelongsTo
  {
    return $this->belongsTo(Owner::class);
  }

  /**
   * Get the tenants of the property.
   */
  public function tenants(): BelongsToMany
  {
    return $this->belongsToMany(Tenant::class, 'tenant_properties')
      ->withPivot(
        'id',
        'start',
        'duration',
        'rating',
        'review',
        'is_reviewed',
        'method',
        'status'
      )
      ->withTimestamps()
      ->using(TenantProperty::class);
  }

  /**
   * Get the bookmarks of the property.
   */
  public function bookmarks(): BelongsToMany
  {
    return $this->belongsToMany(Tenant::class, 'tenant_bookmarks');
  }

  /**
   * Get the rating of the property by average of the tenants ratings.
   */
  public function getRatingAttribute(): float | null
  {
    return $this->tenants()->avg('rating');
  }

  /**
   * Getter for checking if current tenant has bookmarked the property.
   */
  public function getBookmarkedAttribute(): bool
  {
    $tenant = Auth::user()->tenant;
    return $this->bookmarks()
      ->where('tenant_id', $tenant->id)
      ->exists();
  }

  /**
   * Getter for the distance property.
   *
   * @return float
   */
  public function getDistanceAttribute(): float
  {
    $tenant = Auth::user()->tenant;

    if (!$tenant) return 0;
    return Distance::haversine(
      $tenant->latitude,
      $tenant->longitude,
      $this->latitude,
      $this->longitude
    );
  }
}
