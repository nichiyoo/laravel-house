<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'title',
    'message',
    'type',
    'action',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected function casts(): array
  {
    return [
      'read' => 'boolean'
    ];
  }

  /**
   * get the user that owns the notification
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * mark notification as read
   */
  public function markAsRead(): void
  {
    $this->update(['read' => true]);
  }
}
