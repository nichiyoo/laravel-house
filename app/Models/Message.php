<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
  protected $fillable = [
    'chat_id',
    'user_id',
    'content',
    'read'
  ];

  protected $casts = [
    'read' => 'boolean'
  ];

  /**
   * get message sender
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * get message chat
   */
  public function chat(): BelongsTo
  {
    return $this->belongsTo(Chat::class);
  }
}
