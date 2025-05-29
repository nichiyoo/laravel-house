<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Bookmarks</x-slot>
      <x-slot:heading>Saved Properties</x-slot>
    </x-title>

    @forelse ($properties as $property)
      <a href="{{ route('tenants.properties.show', $property) }}">
        <x-properties.card :property="$property" />
      </a>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-app-layout>
