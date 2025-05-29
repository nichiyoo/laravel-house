<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Search</x-slot>
      <x-slot:heading>Explore properties</x-slot>
      <x-slot:actions>
        <x-filter :route="route('tenants.properties.index')">
          <x-button size="icon">
            <i data-lucide="list-filter" class="size-5"></i>
            <span class="sr-only">filter</span>
          </x-button>
        </x-filter>
      </x-slot:actions>
    </x-title>

    <section>
      <x-search action="{{ route('tenants.properties.index') }}" />
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
        <a href="{{ route('tenants.properties.show', $property) }}">
          <x-properties.card :property="$property" />
        </a>
      @empty
        <x-empty />
      @endforelse
    </section>
  </div>
</x-app-layout>
