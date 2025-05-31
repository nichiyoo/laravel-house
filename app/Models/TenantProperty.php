<?php

namespace App\Models;

use App\Enums\MethodType;
use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TenantProperty extends Pivot
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
    'is_reviewed',
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
      'is_reviewed' => 'boolean',
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

  /**
   * Getter for total price by multiplying the property price with the duration.
   */
  public function getTotalAttribute(): int
  {
    return $this->property->price * $this->duration * $this->property->interval->ratio();
  }

  /**
   * Override the pivot status attribute for completed.
   */
  public function status(): Attribute
  {
    return Attribute::make(
      get: function () {
        $status = $this->attributes['status'];
        $status = StatusType::tryFrom($status);

        if ($status !== StatusType::APPROVED) return $status;

        $now = now();
        $start = $this->start;
        $end = $start->addMonths($this->duration * $this->property->interval->ratio());
        if ($now->greaterThanOrEqualTo($end)) return StatusType::COMPLETED;

        return $status;
      }
    );
  }
}
