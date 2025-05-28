<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string>
   */
  protected $fillable = [
    'user_id',
  ];

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = ['user'];

  /**
   * Get the user that owns the admin.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
