<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Profile</x-slot>
      <x-slot:heading>Account Settings</x-slot>
    </x-title>

    <section class="grid items-center min-h-56">
      <div class="flex flex-col items-center gap-4">
        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-32 h-32 rounded-full" />
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
                  'href' => route('owners.applications'),
                  'label' => 'Applications',
                  'icon' => 'shopping-bag',
              ],
              [
                  'href' => route('help'),
                  'label' => 'Help',
                  'icon' => 'life-buoy',
              ],
              [
                  'href' => '#',
                  'label' => 'Settings',
                  'icon' => 'bolt',
              ],
          ])->map(fn($item) => (object) $item);
        @endphp

        @foreach ($navigations as $navigation)
          <li>
            <a href="{{ $navigation->href }}" class="flex items-center gap-4 py-4">
              <i data-lucide="{{ $navigation->icon }}" class="size-5"></i>
              <span>{{ $navigation->label }}</span>
            </a>
          </li>
        @endforeach

        <li>
          <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-4 py-4 text-red-500">
              <i data-lucide="log-out" class="size-5"></i>
              <span>Logout</span>
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</x-app-layout>
