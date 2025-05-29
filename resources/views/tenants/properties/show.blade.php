<x-detail-layout :property="$property">
  <div class="grid gap-6 p-side">
    <p class="text-base-500 ">
      {{ $property->description }}
    </p>

    <div class="grid grid-cols-2 gap-2">
      @php
        $details = [
            'City' => $property->city,
            'Region' => $property->region,
            'Zipcode' => $property->zipcode,
            'Capacity' => $property->capacity . ' rooms',
            'Payment' => $property->interval->label(),
        ];
      @endphp

      @foreach ($details as $key => $value)
        <dl class=" grid gap-2">
          <dt class="font-medium">{{ $key }}</dt>
          <dd class="text-base-500">{{ $value }}</dd>
        </dl>
      @endforeach
    </div>

    @if ($property->images)
      <div class="grid grid-cols-2 gap-4">
        @foreach ($property->images as $image)
          <div class="overflow-hidden aspect-thumbnail rounded-xl">
            <img src="{{ asset($image) }}" alt="Property image" class="object-cover size-full" />
          </div>
        @endforeach
      </div>
    @endif

    <ul class="grid grid-cols-2 gap-4">
      @foreach ($property->amenities as $amenity)
        <x-amenity :amenity="$amenity" />
      @endforeach
    </ul>
  </div>
</x-detail-layout>
