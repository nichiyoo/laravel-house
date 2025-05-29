<x-app-layout :padding="false">
  <div class="grid gap-6 p-side">
    <x-title>
      <x-slot:section>Your location</x-slot>
      <x-slot:heading>{{ Auth::user()->tenant->address }}</x-slot>
    </x-title>

    <section>
      <x-search action="{{ route('tenants.properties.index') }}" />
    </section>
  </div>

  <div class="grid gap-6">
    <section class="grid gap-4">
      <h1 class="text-2xl font-semibold px-side">
        Nearest properties
      </h1>

      <div class="overflow-hidden embla px-side" id="slides">
        <div class="flex embla__container">
          @foreach ($nearest as $property)
            <a href="{{ route('tenants.properties.show', $property) }}"
              class="relative flex-none mr-4 overflow-hidden embla__slide basis-11/12 aspect-thumbnail size-full rounded-2xl side">
              <img src="{{ $property->backdrop }}" alt="{{ $property->name }}"
                class="absolute object-cover size-full" />
              <div class="absolute inset-0 bg-gradient-to-tr from-base-950/80 to-transparent"></div>

              <div class="relative flex flex-col justify-end h-full p-6 text-white">
                <span>Rp {{ number_format($property->price) }}</span>
                <h4 class="text-2xl font-medium truncate">{{ $property->name }}</h4>
                <p class="text-sm truncate opacity-50">{{ $property->address }}</p>
              </div>

              <div class="absolute top-0 flex items-center justify-between w-full p-6 text-sm text-white">
                <div class="flex items-center gap-2 text-yellow-400">
                  <i data-lucide="star" class="fill-current size-5"></i>
                  <span>{{ round($property->rating, 1) }}</span>
                </div>
                <span>{{ round($property->distance, 1) }} Km</span>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <section class="grid gap-4">
      <h2 class="text-lg font-medium px-side">
        Latest properties
      </h2>

      <div class="overflow-hidden embla px-side" id="chips">
        <div class="flex embla__container">
          @foreach (collect($latest)->chunk(2) as $chunk)
            <div class="grid flex-none gap-4 mr-4 basis-3/4 embla__slide">
              @foreach ($chunk as $property)
                <a href="{{ route('tenants.properties.show', $property) }}"
                  class="grid items-center grid-cols-3 gap-4 overflow-hidden card">
                  <div class="aspect-square">
                    <img src="{{ $property->backdrop }}" alt="{{ $property->name }}" class="object-cover size-full" />
                  </div>
                  <div class="col-span-2 font-medium">
                    <h4 class="truncate">{{ $property->name }}</h4>
                    <span class="text-sm text-primary-500">
                      <x-currency :amount="$property->price" />
                    </span>
                  </div>
                </a>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>

  <div class="grid gap-6 p-side">
    <section class="grid gap-4">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium">
          Other properties
        </h2>

        <a href="{{ route('tenants.properties.index') }}" class="flex items-center gap-2 text-sm text-primary-500">
          <span>Explore</span>
          <i data-lucide="arrow-up-right" class="size-4"></i>
        </a>
      </div>

      @foreach ($others as $property)
        <a href="{{ route('tenants.properties.show', $property) }}">
          <x-properties.card :property="$property" />
        </a>
      @endforeach
    </section>
  </div>
</x-app-layout>
