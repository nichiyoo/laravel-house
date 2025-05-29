<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Applications</x-slot>
      <x-slot:heading>Rental Applications</x-slot>
    </x-title>

    @forelse ($properties as $property)
      <a href="{{ route('tenants.properties.show', $property) }}" class="relative">
        <x-properties.card :property="$property" :transaction="$property->pivot" />
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
