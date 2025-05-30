<?php

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function (User $user, $id) {
  return  Chat::where('id', (int) $id)
    ->where(function ($query) use ($user) {
      $query->where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id);
    })
    ->exists();
});
