<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
  /**
   * send notification to user
   */
  public function send(User $user, string $title, string $message, string $type = 'info'): Notification
  {
    return Notification::create([
      'user_id' => $user->id,
      'title' => $title,
      'message' => $message,
      'type' => $type
    ]);
  }

  /**
   * send notification to multiple users
   */
  public function broadcast(Collection $users, string $title, string $message, string $type = 'info'): void
  {
    foreach ($users as $user) {
      $this->send($user, $title, $message, $type);
    }
  }
}
