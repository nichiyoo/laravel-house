<div class="grid gap-4 grid-cols-2">
  <div class="col-span-full">
    <x-label for="name" value="Property Name" />
    <x-input id="name" type="text" name="name" value="{{ old('name', $property->name) }}" required
      placeholder="Enter property name" autofocus />
    <x-error :messages="$errors->get('name')" />
  </div>

  <div class="col-span-full">
    <x-label for="backdrop" value="Property Backdrop" />
    <x-upload name="backdrop" :value="old('backdrop', $property->backdrop)" placeholder="Change backdrop" />
    <x-error :messages="$errors->get('backdrop')" />
  </div>

  <div>
    <x-label for="price" value="Price (monthly)" />
    <x-input id="price" type="number" name="price" value="{{ old('price', $property->price) }}" required
      placeholder="Enter rental price" min="0" step="100000" />
    <x-error :messages="$errors->get('price')" />
  </div>

  <div>
    <x-label for="capacity" value="Capacity" />
    <x-input id="capacity" type="number" name="capacity" value="{{ old('capacity', $property->capacity) }}" required
      placeholder="Number of occupants" min="0" />
    <x-error :messages="$errors->get('capacity')" />
  </div>

  <div>
    <x-label for="interval" value="Payment" />
    <x-select id="interval" name="interval" required>
      @foreach ($intervals as $interval)
        <option value="{{ $interval->value }}"
          {{ old('interval', $property->interval?->value) === $interval->value ? 'selected' : '' }}>
          {{ $interval->label() }}
        </option>
      @endforeach
    </x-select>
    <x-error :messages="$errors->get('interval')" />
  </div>

  @php
    $actives = $property->amenities?->pluck('value')->toArray() ?? [];
    $previous = old('amenities', $actives);
  @endphp

  <div class="col-span-full">
    <x-label value="Amenities" />
    <div class="grid grid-cols-2 gap-4">
      @foreach ($amenities as $amenity)
        <div x-data="{ checked: @js(in_array($amenity->value, $previous)) }">
          <input type="checkbox" id="amenity-{{ $amenity->value }}" name="amenities[]" value="{{ $amenity->value }}"
            class="hidden" x-bind:checked="checked">

          <button type="button" x-on:click="checked = !checked"
            x-bind:class="checked && 'border-primary-500 ring-1 ring-primary-500'"
            class="flex items-center w-full gap-3 p-3 text-sm bg-base-50 border rounded-xl ">
            <i data-lucide="{{ $amenity->icon() }}" class="size-5"></i>
            <div class="truncate">{{ $amenity->label() }}</div>
          </button>
        </div>
      @endforeach
    </div>
    <x-error :messages="$errors->get('amenities')" />
  </div>

  <div class="col-span-full">
    <x-label for="description" value="Description" />
    <x-textarea id="description" name="description" required
      placeholder="Describe your property">{{ old('description', $property->description) }}</x-textarea>
    <x-error :messages="$errors->get('description')" />
  </div>

  <div class="col-span-full">
    <x-label for="images" value="Property Images" />
    <x-multiple name="images" :value="old('images', $property->images)" placeholder="Change images" multiple />
    <x-error :messages="$errors->get('images')" />
  </div>

  <div class="col-span-full">
    <x-label for="address" value="Address" />
    <x-textarea id="address" name="address" required
      placeholder="Enter property address">{{ old('address', $property->address) }}</x-textarea>
    <x-error :messages="$errors->get('address')" />
  </div>

  <div>
    <x-label for="city" value="City" />
    <x-input id="city" type="text" name="city" value="{{ old('city', $property->city) }}" required
      placeholder="City" />
    <x-error :messages="$errors->get('city')" />
  </div>

  <div>
    <x-label for="region" value="Region/State" />
    <x-input id="region" type="text" name="region" value="{{ old('region', $property->region) }}" required
      placeholder="Region or State" />
    <x-error :messages="$errors->get('region')" />
  </div>

  <div>
    <x-label for="zipcode" value="Zipcode" />
    <x-input id="zipcode" type="text" name="zipcode" value="{{ old('zipcode', $property->zipcode) }}" required
      placeholder="Enter zipcode" />
    <x-error :messages="$errors->get('zipcode')" />
  </div>

  <div class="col-span-full">
    <x-label for="location" value="Location" />
    <div id="map" class="z-0 w-full aspect-thumbnail card"></div>
  </div>

  <div>
    <x-label for="latitude" value="Latitude" />
    <x-input id="latitude" type="text" name="latitude" value="{{ old('latitude', $property->latitude) }}" required
      readonly />
    <x-error :messages="$errors->get('latitude')" />
  </div>

  <div>
    <x-label for="longitude" value="Longitude" />
    <x-input id="longitude" type="text" name="longitude" value="{{ old('longitude', $property->longitude) }}"
      required readonly />
    <x-error :messages="$errors->get('longitude')" />
  </div>
</div>

@push('scripts')
  @vite(['resources/js/leaflet.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const latitude = parseFloat(document.getElementById('latitude').value) || {{ $location->latitude }};
      const longitude = parseFloat(document.getElementById('longitude').value) || {{ $location->longitude }};

      const map = L.map('map', {
        zoomControl: true
      }).setView([latitude, longitude], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
      }).addTo(map);

      let marker = L.marker([latitude, longitude], {
        draggable: true
      }).addTo(map);

      function updateMarker(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
      }

      marker.on('dragend', function(event) {
        const position = marker.getLatLng();
        updateMarker(position.lat, position.lng);
      });

      map.on('click', function(e) {
        const position = e.latlng;
        marker.setLatLng(position);
        updateMarker(position.lat, position.lng);
      });

      updateMarker(latitude, longitude);
    });
  </script>
@endpush
