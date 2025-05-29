<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Rent Property</x-slot>
      <x-slot:heading>{{ $property->name }}</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('tenants.properties.store', $property) }}">
      @csrf
      @include('tenants.properties.form', [
          'property' => $property,
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Submit Rental</span>
    </x-button>
  </div>
</x-app-layout>
