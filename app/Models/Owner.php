<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owner extends Model
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
   * Get the user that owns the owner.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
