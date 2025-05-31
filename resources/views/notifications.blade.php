<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Activity</x-slot>
      <x-slot:heading>Notification and Messages</x-slot>
      <x-slot:actions>
        <a href="{{ route('chats.index') }}">
          <x-button size="icon">
            <i data-lucide="message-circle" class="size-5"></i>
            <span class="sr-only">chat</span>
          </x-button>
        </a>
      </x-slot:actions>
    </x-title>

    @forelse ($notifications as $notification)
      <a href="{{ $notification->action }}" class="card" x-data="{ hover: false }" x-on:mouseenter="hover = true"
        x-on:mouseleave="hover = false">
        <div class="flex items-start gap-4 p-6 text-sm">
          <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="flex-none lucide lucide-bell-icon lucide-bell text-primary-500 size-5"
                x-bind:class="hover && 'hidden'">
                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                <path
                  d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
              </svg>

              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="flex-none text-red-500 lucide lucide-trash-icon lucide-trash size-5"
                x-bind:class="!hover && 'hidden'">
                <path d="M3 6h18" />
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
              </svg>
            </button>
          </form>

          <div class="grid flex-1 gap-1">
            <h3 class="font-medium">{{ $notification->title }}</h3>
            <p class="text-base-500">{{ $notification->message }}</p>
            <p>{{ $notification->created_at->diffForHumans() }}</p>
          </div>
        </div>
      </a>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-app-layout>
