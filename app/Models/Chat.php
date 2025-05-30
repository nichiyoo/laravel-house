<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
  /**
   * fillable attributes
   * 
   * @var array<string>
   */
  protected $fillable = [
    'sender_id',
    'receiver_id'
  ];

  /**
   * get chat sender
   */
  public function sender(): BelongsTo
  {
    return $this->belongsTo(User::class, 'sender_id');
  }

  /**
   * get chat receiver
   */
  public function receiver(): BelongsTo
  {
    return $this->belongsTo(User::class, 'receiver_id');
  }

  /**
   * get chat messages
   */
  public function messages(): HasMany
  {
    return $this->hasMany(Message::class);
  }
}
