<x-app-layout>
  <div id="map" class="absolute inset-0 z-0 w-full h-screen"></div>

  <section class="absolute inset-0 w-full p-side">
    <div class="flex items-center justify-between gap-2">
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

  @push('scripts')
    @vite(['resources/js/leaflet.js'])

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const property = @json($property);
        const price = Number({{ $property->price }});

        const location = [property.latitude, property.longitude];
        const map = L.map('map', {
          maxZoom: 15,
          minZoom: 10,
          zoomControl: false
        }).setView(location, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        const formatCurrency = (value, currency) => {
          return value.toLocaleString('id-ID', {
            style: 'currency',
            currency: currency,
          });
        };

        L.marker(location, {
            riseOnHover: true
          })
          .addTo(map)
          .bindPopup(`<strong>${property.name}</strong><br>${formatCurrency(price, 'IDR')}`)
          .openPopup();
      });
    </script>
  @endpush
</x-app-layout>
