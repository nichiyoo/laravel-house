<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Activity</x-slot>
      <x-slot:heading>Notification and Messages</x-slot>
      <x-slot:actions>
        <form action="{{ route('notifications.purge') }}" method="POST">
          @csrf
          @method('DELETE')
          <x-button type="submit" size="icon" variant="destructive">
            <i data-lucide="trash" class="size-5"></i>
            <span class="sr-only">delete</span>
          </x-button>
        </form>
      </x-slot:actions>
    </x-title>

    @forelse ($notifications as $notification)
      <div class="card" x-data="{ hover: false }" x-on:mouseenter="hover = true" x-on:mouseleave="hover = false">
        <div class="p-6 flex items-start gap-4 text-sm">
          <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bell-icon lucide-bell text-primary-500 flex-none size-5"
                x-bind:class="hover && 'hidden'">
                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                <path
                  d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
              </svg>

              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-trash-icon lucide-trash text-red-500 flex-none size-5"
                x-bind:class="!hover && 'hidden'">
                <path d="M3 6h18" />
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
              </svg>
            </button>
          </form>

          <div class="flex-1 grid gap-1">
            <h3 class="font-medium">{{ $notification->title }}</h3>
            <p class="text-base-500">{{ $notification->message }}</p>
            <p>{{ $notification->created_at->diffForHumans() }}</p>
          </div>
        </div>
      </div>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-app-layout>
