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
      <div class="card">
        <div class="p-6 flex items-start gap-4 text-sm">
          <i data-lucide="bell" class="size-5 text-primary-500 flex-none"></i>

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
