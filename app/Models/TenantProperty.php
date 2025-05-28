<?php

namespace App\Models;

use App\Enums\MethodType;
use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantProperty extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string>
   */
  protected $fillable = [
    'tenant_id',
    'property_id',
    'start',
    'duration',
    'method',
    'status',
    'rating',
    'review',
  ];

  /**
   * The attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'start' => 'date',
      'method' => MethodType::class,
      'status' => StatusType::class,
    ];
  }

  /**
   * Get the tenant that rents the property.
   */
  public function tenant(): BelongsTo
  {
    return $this->belongsTo(Tenant::class);
  }

  /**
   * Get the property that is rented.
   */
  public function property(): BelongsTo
  {
    return $this->belongsTo(Property::class);
  }
}
