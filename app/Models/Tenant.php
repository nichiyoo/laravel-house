<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
   * @var array<string, string>
   */
  protected $casts = [
    'completed' => 'boolean',
    'latitude' => 'decimal:6',
    'longitude' => 'decimal:6',
  ];

  /**
   * Get the user that owns the tenant.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
