<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return true;
  }

  /**
   * Determine whether the user can read the model.
   */
  public function read(User $user, Notification $notification): bool
  {
    return $notification->user->is($user);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function all(User $user): bool
  {
    return true;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Notification $notification): bool
  {
    return $notification->user->is($user);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function purge(User $user): bool
  {
    return true;
  }
}
