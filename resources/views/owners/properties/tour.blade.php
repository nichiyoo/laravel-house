<x-app-layout>
  <div id="viewer" class="absolute inset-0 w-full h-full"></div>

  <section class="absolute top-0 left-0 w-full p-side">
    <div class="flex items-center justify-between gap-2 w-full">
      <a href="{{ route('owners.properties.show', $property) }}">
        <x-button size="icon">
          <i data-lucide="chevron-left" class="size-5"></i>
          <span class="sr-only">Back</span>
        </x-button>
      </a>

      <x-delete id="{{ $property->id }}" title="{{ $property->name }}"
        route="{{ route('owners.properties.destroy', $property) }}">
        <x-button size="icon" variant="destructive">
          <i data-lucide="trash" class="size-5"></i>
          <span class="sr-only">Delete</span>
        </x-button>
      </x-delete>
    </div>
  </section>

  <div class="absolute bottom-0 left-0 w-full p-side">
    <div class="flex gap-2 justify-center items-center">
      @foreach ($images as $image)
        <a href="{{ route('owners.properties.room', ['property' => $property, 'room' => $loop->index]) }}"
          class="basis-1/6 aspect-square overflow-hidden rounded-xl">
          <img src="{{ $image }}" class="size-full object-cover">
        </a>
      @endforeach
    </div>
  </div>

  @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.min.css" />

    <script type="importmap">
      {
        "imports": {
          "three": "https://cdn.jsdelivr.net/npm/three/build/three.module.js",
          "@photo-sphere-viewer/core": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core@5.13.2/index.module.min.js",
          "@photo-sphere-viewer/gyroscope-plugin": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/gyroscope-plugin@5.13.2/index.module.min.js"
        }
      }
    </script>

    <script type="module">
      import {
        Viewer
      } from '@photo-sphere-viewer/core';
      import {
        GyroscopePlugin
      } from '@photo-sphere-viewer/gyroscope-plugin';


      document.addEventListener('DOMContentLoaded', function() {
        const viewer = document.getElementById('viewer');

        if (viewer) {
          new Viewer({
            container: viewer,
            panorama: @json($room),
            navbar: false,
            defaultZoomLvl: 0,
            plugins: [
              GyroscopePlugin
            ]
          });
        }
      });
    </script>
  @endpush
</x-app-layout>
