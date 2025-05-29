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
      <div class="flex flex-col justify-center gap-4 h-96">
        <div class="flex items-center justify-center gap-2 text-zinc-500">
          <span>Oops! No properties found.</span>
          <i data-lucide="search" class="size-4"></i>
        </div>
      </div>
    @endforelse
  </div>
</x-app-layout>
