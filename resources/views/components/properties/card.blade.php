@props([
    'property' => null,
])

<div class="card">
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

  <div class="relative w-full aspect-video bg-base-100">
    <img src="{{ $property->backdrop ?? asset('images/property.jpg') }}" alt="{{ $property->name }}"
      class="object-cover size-full" />

    <div class="absolute top-0 right-0 w-full p-4 text-xs font-medium">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 px-2 py-1 text-yellow-400 rounded-full bg-base-50">
          <i data-lucide="star" class="fill-current size-5"></i>
          <span>
            {{ $property->rating ? round($property->rating, 1) : 'Not rated' }}
          </span>
        </div>

        @tenant
          <div class="px-2 py-1 rounded-full bg-base-50">
            <span>{{ round($property->distance, 1) }} Km</span>
          </div>
        @endtenant
      </div>
    </div>
  </div>

  <div class="flex flex-col gap-1 p-6">
    <h3>{{ $property->name }}</h3>
    <p class="text-sm truncate text-base-500">{{ $property->address }}</p>
    <p class="flex items-center gap-2 text-primary-500">
      <span>Rp {{ number_format($property->price) }}</span>
    </p>
  </div>
</div>
