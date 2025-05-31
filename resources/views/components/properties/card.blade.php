@props([
    'property' => null,
])

<div class="card overflow-hidden">
  <div class="flex items-center justify-between gap-4 p-4">
    <x-profile :user="$property->owner->user" />

    @tenant
      <form method="POST" action="{{ route('tenants.properties.bookmark', $property) }}">
        @csrf
        <button size="icon" class="@if ($property->bookmarked) text-primary-500 @endif">
          <i data-lucide="bookmark" class="size-5 @if ($property->bookmarked) fill-current @endif"></i>
          <span class="sr-only">Bookmark</span>
        </button>
      </form>
    @endtenant
  </div>

  <div class="relative w-full aspect-video bg-base-100 ">
    <img src="{{ $property->backdrop }}" alt="{{ $property->name }}" @class([
        'object-cover size-full',
        'grayscale' => $property->capacity === 0,
    ]) />

    @if ($property->capacity === 0)
      <div class="absolute bottom-0 aspect-video items-end p-6">
        <x-badge variant="destructive">
          <span>Fully booked</span>
        </x-badge>
      </div>
    @endif

    <div class="absolute inset-0 w-full p-6">
      <div class="flex items-center justify-between">
        <x-badge variant="primary">
          <x-rating rating="{{ $property->rating }}" size="small" />
        </x-badge>

        @tenant
          <x-badge variant="secondary">
            <span>{{ round($property->distance, 1) }} Km</span>
          </x-badge>
        @else
          <x-badge variant="secondary">
            <span>{{ $property->verification->label() }}</span>
          </x-badge>
        @endtenant

      </div>
    </div>
  </div>

  <div class="grid gap-1 p-6">
    <h3 class="font-medium">{{ $property->name }}</h3>
    <p class="text-sm truncate text-base-500">{{ $property->address }}</p>
    <span class="text-primary-500">Rp {{ number_format($property->price) }}/month</span>
  </div>

  {{ $slot }}
</div>
