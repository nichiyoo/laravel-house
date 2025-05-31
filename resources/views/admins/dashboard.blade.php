  <x-app-layout>
    <div class="grid gap-6">
      <x-title>
        <x-slot:section>Welcome Back</x-slot>
        <x-slot:heading>{{ Auth::user()->name }}</x-slot>
      </x-title>

      <section>
        <x-search action="{{ route('admins.properties.unverified') }}" />
      </section>

      <section class="grid grid-cols-2 gap-4">
        <h1 class="text-2xl font-semibold">
          Statistics
        </h1>

        <div class="p-4 card col-span-full">
          <h2>User count</h2>
          <span class="text-2xl font-bold text-primary-500">{{ $users }}</span>
        </div>

        <div class="p-4 card">
          <h2>Property count</h2>
          <span class="text-2xl font-bold text-primary-500">{{ $properties }}</span>
        </div>

        <div class="p-4 card">
          <h2>Unverified count</h2>
          <span class="text-2xl font-bold text-primary-500">{{ $unverified }}</span>
        </div>
      </section>

      <section class="grid gap-4">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-medium">
            Latest unverified properties
          </h2>

          <a href="{{ route('admins.properties.unverified') }}"
            class="flex items-center gap-2 text-sm text-primary-500">
            <span>View all</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </a>
        </div>

        @forelse ($latest as $property)
          <a href="{{ route('admins.properties.show', $property) }}">
            <x-properties.card :property="$property">
              <form method="POST" action="{{ route('admins.properties.approve', $property) }}">
                @csrf
                <button
                  class="border-t text-sm px-6 py-4 flex items-center justify-center gap-2 bg-green-500 text-white w-full">
                  Approve
                </button>
              </form>
            </x-properties.card>
          </a>
        @empty
          <x-empty />
        @endforelse
      </section>
    </div>
  </x-app-layout>
