<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Properties</x-slot>
      <x-slot:heading>Manage properties</x-slot>
    </x-title>

    <section>
      <x-search action="{{ route('owners.properties.index') }}" />
    </section>

    <section class="grid gap-4">
      <h2 class="font-medium">
        @if (request()->get('query'))
          Result for keywords "{{ request()->get('query') }}"
        @else
          Available properties
        @endif
      </h2>

      @forelse ($properties as $property)
        <a href="{{ route('owners.properties.show', $property) }}">
          <x-properties.card :property="$property" />
        </a>
      @empty
        <div class="flex flex-col justify-center gap-4 h-96">
          <div class="flex items-center justify-center gap-2 text-zinc-500">
            <span>Oops! No properties found.</span>
            <i data-lucide="search" class="size-5"></i>
          </div>

          <div class="flex justify-center">
            <a href="{{ route('owners.properties.index') }}">
              <x-button>
                Reset
              </x-button>
            </a>
          </div>
        </div>
      @endforelse
    </section>
  </div>
</x-app-layout>
