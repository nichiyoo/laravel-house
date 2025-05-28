<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Edit Property</x-slot>
      <x-slot:heading>{{ $property->name }}</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('owners.properties.update', $property) }}"
      enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('owners.properties.form', [
          'property' => $property,
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Update Property</span>
    </x-button>
  </div>
</x-app-layout>
