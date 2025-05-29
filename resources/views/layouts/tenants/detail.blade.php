<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel House') }}</title>

  <!-- metadata -->
  <meta name="description" content="Laravel House is a platform for managing your home.">

  <!-- vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div class="mobile h-screen overflow-hidden relative">
    <x-status variant="success" status="{{ session('success') }}" />
    <x-status variant="error" status="{{ session('error') }}" />

    <div class="absolute top-0 w-full aspect-square">
      <img src="{{ $property->backdrop ?? asset('images/property.jpg') }}" alt="{{ $property->name }}"
        class="object-cover size-full" />
      <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 to-transparent"></div>
    </div>

    <main class="h-content overflow-y-auto relative">
      <div class="grid gap-6">
        <div class="p-side pb-16 flex flex-col justify-between aspect-square text-base-50">
          <div class="flex items-center justify-between gap-2">
            <a href="{{ route('tenants.properties.index') }}">
              <x-button size="icon">
                <i data-lucide="chevron-left" class="size-5"></i>
                <span class="sr-only">Back</span>
              </x-button>
            </a>

            <form method="POST" action="{{ route('tenants.properties.bookmark', $property) }}">
              @csrf
              <x-button size="icon">
                <i data-lucide="bookmark" class="size-5 @if ($property->bookmarked) fill-current @endif"></i>
                <span class="sr-only">Bookmark</span>
              </x-button>
            </form>
          </div>

          <x-profile :user="$property->owner->user" />
        </div>

        <section class="grid bg-zinc-50 rounded-t-3xl -mt-16">
          <div class="flex flex-col py-6 overflow-hidden p-side">
            <span class="text-sm text-zinc-400">Detail</span>
            <h2 class="truncate text-2xl font-semibold">
              {{ $property->name }}
            </h2>

            <span class="truncate text-zinc-500">{{ $property->address }}</span>

            <div class="flex items-center justify-between mt-2">
              <x-rating rating="{{ $property->rating }}" expanded />
              <x-currency :amount="$property->price" />
            </div>
          </div>

          <div class="grid grid-cols-2 border-y border-zinc-200">
            <div class="flex items-center justify-center p-4 border-r border-zinc-200">
              <a href="{{ route('tenants.properties.show', $property) }}"
                class="@if (request()->routeIs('tenants.properties.show', $property)) text-primary-500 @endif">
                <span>Detail</span>
              </a>
            </div>
            <div class="flex items-center justify-center p-4 border-r border-zinc-200">
              <a href="{{ route('tenants.properties.reviews', $property) }}"
                class="@if (request()->routeIs('tenants.properties.reviews', $property)) text-primary-500 @endif">
                <span>Review</span>
              </a>
            </div>
          </div>

          <div class="min-h-screen">
            {{ $slot }}
          </div>
        </section>
      </div>
    </main>

    <nav class="h-navbar border-t">
      <div class="grid gap-4 grid-cols-2 p-4">
        <a href="{{ route('tenants.properties.location', $property) }}">
          <x-button variant="secondary">
            <i data-lucide="map" class="size-5"></i>
            <span>Location</span>
          </x-button>
        </a>

        <a href="{{ route('tenants.properties.rent', $property) }}">
          <x-button>
            <i data-lucide="shopping-bag" class="size-5"></i>
            <span>Rent</span>
          </x-button>
        </a>
      </div>
    </nav>
  </div>
</body>

</html>
