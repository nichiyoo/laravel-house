<?php

namespace App\Models;

use App\Enums\AmenitiesType;
use App\Enums\IntervalType;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Property extends Model
{
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
      'amenities' => AsEnumCollection::of(AmenitiesType::class),
    ];
  }

  /**
   * Get the owner that owns the property.
   */
  public function owner(): BelongsTo
  {
    return $this->belongsTo(Owner::class);
  }

  /**
   * Get the renters of the property.
   */
  public function renters(): BelongsToMany
  {
    return $this->belongsToMany(Tenant::class, 'tenant_properties')
      ->withPivot(
        'start',
        'duration',
        'rating',
        'review',
        'method',
        'status'
      )
      ->withTimestamps();
  }

  /**
   * Get the bookmarks of the property.
   */
  public function bookmarks(): BelongsToMany
  {
    return $this->belongsToMany(Tenant::class, 'tenant_bookmarks');
  }

  /**
   * Get the rating of the property by average of the renters ratings.
   */
  public function getRatingAttribute(): float
  {
    return $this->renters()->avg('pivot.rating');
  }

  /**
   * Getter for checking if current tenant has bookmarked the property.
   */
  public function getBookmarkedAttribute(): bool
  {
    $tenant = Auth::user()->tenant;
    return $this->bookmarks()->where('tenant_id', $tenant->id)->exists();
  }
}
