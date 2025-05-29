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
      <div class="absolute inset-0 bg-gradient-to-t from-base-950 to-transparent"></div>
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

        <section class="grid bg-base-50 rounded-t-3xl -mt-16">
          <div class="flex flex-col py-6 overflow-hidden p-side">
            <span class="text-sm text-base-400">Detail</span>
            <h2 class="truncate text-2xl font-semibold">
              {{ $property->name }}
            </h2>

            <span class="truncate text-base-500">{{ $property->address }}</span>

            <div class="flex items-center justify-between mt-2">
              <x-rating rating="{{ $property->rating }}" expanded />
              <x-currency :amount="$property->price" />
            </div>
          </div>

          <div class="grid grid-cols-2 border-y">
            @php
              $tabs = collect([
                  [
                      'label' => 'Detail',
                      'route' => route('tenants.properties.show', $property),
                      'active' => request()->routeIs('tenants.properties.show', $property),
                  ],
                  [
                      'label' => 'Review',
                      'route' => route('tenants.properties.reviews', $property),
                      'active' => request()->routeIs('tenants.properties.reviews', $property),
                  ],
              ])->map(fn($tab) => (object) $tab);
            @endphp

            @foreach ($tabs as $tab)
              <div class="flex items-center justify-center p-4 border-r">
                <a href="{{ $tab->route }}" class="@if ($tab->active) text-primary-500 @endif">
                  <span>{{ $tab->label }}</span>
                </a>
              </div>
            @endforeach
          </div>

          {{ $slot }}
        </section>
      </div>
    </main>

    <nav class="h-navbar border-t bg-base-50">
      <div class="grid gap-4 grid-cols-2 p-4">
        @php
          $actions = collect([
              [
                  'label' => 'Location',
                  'route' => route('tenants.properties.location', $property),
                  'icon' => 'map',
              ],
              [
                  'label' => 'Rent',
                  'route' => route('tenants.properties.rent', $property),
                  'icon' => 'shopping-bag',
              ],
          ])->map(fn($action) => (object) $action);
        @endphp

        @foreach ($actions as $action)
          <a href="{{ $action->route }}">
            <x-button variant="secondary">
              <i data-lucide="{{ $action->icon }}" class="size-5"></i>
              <span>{{ $action->label }}</span>
            </x-button>
          </a>
        @endforeach
      </div>
    </nav>
  </div>
</body>

</html>
