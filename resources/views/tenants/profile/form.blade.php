<div class="grid gap-4 grid-cols-2">
  <div class="col-span-full">
    <x-label for="name" value="Name" />
    <x-input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" />
    <x-error :messages="$errors->get('name')" />
  </div>

  <div class="col-span-full">
    <x-label for="phone" value="Phone" />
    <x-input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" />
    <x-error :messages="$errors->get('phone')" />
  </div>

  <div class="col-span-full">
    <x-label for="avatar" value="Avatar" />
    <x-upload id="avatar" name="avatar" value="{{ old('avatar', $user->avatar) }}" placeholder="Change avatar" />
    <x-error :messages="$errors->get('avatar')" />
  </div>

  <div>
    <x-label for="password" value="Password" />
    <x-input id="password" name="password" type="password" />
    <x-error :messages="$errors->get('password')" />
  </div>

  <div>
    <x-label for="password_confirmation" value="Password Confirmation" />
    <x-input id="password_confirmation" name="password_confirmation" type="password" />
    <x-error :messages="$errors->get('password_confirmation')" />
  </div>

  <div class="col-span-full">
    <x-label for="address" value="Address" />
    <x-textarea id="address" name="address" placeholder="Enter your address"
      rows="3">{{ old('address', $tenant->address) }}</x-textarea>
    <x-error :messages="$errors->get('address')" />
  </div>

  <div class="col-span-full">
    <x-label for="location" value="Location" />
    <div id="map" class="z-0 w-full aspect-thumbnail card"></div>
  </div>

  <div>
    <x-label for="latitude" value="Latitude" />
    <x-input id="latitude" type="text" name="latitude" value="{{ old('latitude', $tenant->latitude) }}" required
      readonly />
    <x-error :messages="$errors->get('latitude')" />
  </div>

  <div>
    <x-label for="longitude" value="Longitude" />
    <x-input id="longitude" type="text" name="longitude" value="{{ old('longitude', $tenant->longitude) }}" required
      readonly />
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
