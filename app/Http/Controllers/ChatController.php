<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChatController extends Controller
{
  /**
   * show chat list
   */
  public function index(): View
  {
    $user = Auth::user();
    $chats = Chat::where('sender_id', $user->id)
      ->orWhere('receiver_id', $user->id)
      ->with(['sender', 'receiver', 'messages' => function ($query) {
        $query->latest()->limit(1);
      }])
      ->get();

    return view('chat.index', [
      'chats' => $chats
    ]);
  }

  /**
   * show chat messages
   */
  public function show(User $target): View
  {
    $user = Auth::user();
    $chat = Chat::where(function ($query) use ($target, $user) {
      $query->where('sender_id', $user->id)->where('receiver_id', $target->id);
    })->orWhere(function ($query) use ($target, $user) {
      $query->where('sender_id', $target->id)->where('receiver_id', $user->id);
    })->first();

    if (!$chat) {
      $chat = Chat::create([
        'sender_id' => $user->id,
        'receiver_id' => $target->id
      ]);
    }

    $messages = $chat->messages()->with('user')->get();

    $chat->messages()
      ->where('user_id', '!=', $user->id)
      ->where('read', false)
      ->update([
        'read' => true
      ]);

    return view('chat.show', [
      'chat' => $chat,
      'messages' => $messages
    ]);
  }

  /**
   * send message
   */
  public function send(Request $request, Chat $chat): JsonResponse
  {
    $validated = $request->validate([
      'content' => ['required', 'string']
    ]);

    $message = $chat->messages()->create([
      'user_id' => Auth::id(),
      'content' => $validated['content']
    ]);

    $message->load('user');
    $event = new MessageSent($message);
    broadcast($event)->toOthers();

    return response()->json([
      'message' => [
        'id' => $message->id,
        'content' => $message->content,
        'created_at' => $message->created_at,
        'user' => [
          'id' => $message->user->id,
          'name' => $message->user->name,
          'avatar' => $message->user->avatar
        ]
      ]
    ]);
  }

  /**
   * get unread count
   */
  public function unread(): JsonResponse
  {
    $user = Auth::user();
    $count = Message::whereHas('chat', function ($query) use ($user) {
      $query->where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id);
    })
      ->where('user_id', '!=', $user->id)
      ->where('read', false)
      ->count();

    return response()->json([
      'count' => $count
    ]);
  }
}
