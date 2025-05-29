<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Review Property</x-slot>
      <x-slot:heading>{{ $property->name }}</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('tenants.properties.update', $property) }}">
      @csrf
      @method('PUT')
      @include('tenants.properties.review.form', [
          'property' => $property,
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Submit Review</span>
    </x-button>
  </div>
</x-app-layout>
