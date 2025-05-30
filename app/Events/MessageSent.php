<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageSent implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   */
  public function __construct(public Message $message)
  {
    // 
  }

  /**
   * Get the channels the event should broadcast on.
   */
  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('chat.' . $this->message->chat_id)
    ];
  }

  /**
   * get the data to broadcast
   */
  public function broadcastWith(): array
  {
    return [
      'message' => [
        'id' => $this->message->id,
        'content' => $this->message->content,
        'created_at' => $this->message->created_at,
        'user' => [
          'id' => $this->message->user->id,
          'name' => $this->message->user->name,
          'avatar' => $this->message->user->avatar
        ]
      ]
    ];
  }

  /**
   * get broadcast event name
   */
  public function broadcastAs(): string
  {
    return 'message.sent';
  }
}
