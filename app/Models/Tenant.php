<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tenant extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string>
   */
  protected $fillable = [
    'user_id',
    'completed',
    'address',
    'latitude',
    'longitude',
  ];

  /**   
   * The attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'completed' => 'boolean',
      'latitude' => 'decimal:6',
      'longitude' => 'decimal:6',
    ];
  }

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = ['user'];

  /**
   * Get the user that owns the tenant.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the properties that the tenant has rented.
   */
  public function rented(): BelongsToMany
  {
    return $this->belongsToMany(Property::class, 'tenant_properties')
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
   * Get the bookmarks of the tenant.
   */
  public function bookmarks(): BelongsToMany
  {
    return $this->belongsToMany(Property::class, 'tenant_bookmarks');
  }
}
