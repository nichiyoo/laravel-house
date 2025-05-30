<x-app-layout>
  <div class="grid gap-6 relative">
    <x-title>
      <x-slot:section>Profile</x-slot>
      <x-slot:heading>Account Settings</x-slot>
    </x-title>

    <section class="grid items-center min-h-56">
      <div class="flex flex-col items-center gap-4">
        <div class="size-40 border border-base-300 rounded-full p-4">
          <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-full" />
        </div>
        <div class="flex flex-col text-center">
          <span class="text-2xl font-semibold">{{ Auth::user()->name }}</span>
          <span class="text-sm text-base-500">{{ Auth::user()->email }}</span>
        </div>
      </div>
    </section>

    <nav class="grid gap-4">
      <ul class="flex flex-col divide-y">
        @php
          $navigations = collect([
              [
                  'href' => route('owners.profile.edit'),
                  'label' => 'Profile',
                  'icon' => 'user-round',
              ],
              [
                  'href' => route('notifications.index'),
                  'label' => 'Notifications',
                  'icon' => 'bell',
              ],
              [
                  'href' => route('owners.applications'),
                  'label' => 'Applications',
                  'icon' => 'shopping-bag',
              ],
              [
                  'href' => route('help'),
                  'label' => 'Help',
                  'icon' => 'life-buoy',
              ],
          ])->map(fn($item) => (object) $item);
        @endphp

        @foreach ($navigations as $navigation)
          <li>
            <a href="{{ $navigation->href }}" class="flex items-center gap-4 py-4">
              <i data-lucide="{{ $navigation->icon }}" class="text-primary-500 size-5"></i>
              <span>{{ $navigation->label }}</span>
            </a>
          </li>
        @endforeach

        <li>
          <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button class="flex items-center gap-4 py-4 text-red-500">
              <i data-lucide="log-out" class="size-5"></i>
              <span>Logout</span>
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</x-app-layout>
