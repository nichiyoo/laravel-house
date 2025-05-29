@php
  use App\Enums\StatusType;
@endphp

<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Applications</x-slot>
      <x-slot:heading>Rental Applications</x-slot>
    </x-title>

    @forelse ($properties as $property)
      <a href="{{ route('owners.properties.applications', $property) }}">
        <x-properties.card :property="$property">
          <div class="border-t p-6">
            <p class="text-sm text-base-500">
              {{ $property->tenants->count() }} pending applications for this property.
            </p>
          </div>
        </x-properties.card>
      </a>
    @empty
      <div class="flex flex-col justify-center gap-4 h-96">
        <div class="flex items-center justify-center gap-2 text-base-500">
          <span>Oops! No properties found.</span>
          <i data-lucide="search" class="size-4"></i>
        </div>
      </div>
    @endforelse
  </div>
</x-app-layout>
