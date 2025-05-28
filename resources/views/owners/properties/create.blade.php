<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Add Property</x-slot>
      <x-slot:heading>Property Details</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('owners.properties.store') }}" enctype="multipart/form-data">
      @csrf
      @include('owners.properties.form', [
          'property' => new App\Models\Property(),
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Create Property</span>
    </x-button>
  </div>
</x-app-layout>
