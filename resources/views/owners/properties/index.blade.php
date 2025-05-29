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
        <x-empty />
      @endforelse
    </section>
  </div>
</x-app-layout>
