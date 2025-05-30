<?php

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
  return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function (User $user, int $id) {
  $chat = Chat::find($id);
  return $chat && ($chat->sender_id === $user->id || $chat->receiver_id === $user->id);
});
