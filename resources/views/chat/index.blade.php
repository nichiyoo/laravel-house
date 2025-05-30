<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Messages</x-slot>
      <x-slot:heading>Chat History</x-slot>
    </x-title>

    <div class="grid gap-4">
      @forelse($chats as $chat)
        @php
          $target = $chat->sender_id === Auth::id() ? $chat->receiver : $chat->sender;
          $message = $chat->messages->first();
        @endphp

        <a href="{{ route('chats.show', $target) }}">
          <div class="card p-4 relative">
            <div class="flex items-start gap-3">
              <img src="{{ $target->avatar }}" alt="{{ $target->name }}" class="size-12 rounded-full" />

              <div class="text-sm">
                <div class="font-medium">{{ $target->name }}</div>
                @if ($message)
                  <p class="text-sm text-base-500">{{ Str::limit($message->content, 50) }}</p>
                  <span class="text-xs text-base-400">{{ $message->created_at->diffForHumans() }}</span>
                @endif
              </div>
            </div>

            @if ($chat->messages()->where('user_id', '!=', Auth::id())->where('read', false)->exists())
              <div class="absolute top-0 right-0">
                <div class="size-3 animate-ping rounded-full bg-primary-500"></div>
              </div>
            @endif
          </div>
        </a>
      @empty
        <x-empty />
      @endforelse
    </div>
  </div>
</x-app-layout>
