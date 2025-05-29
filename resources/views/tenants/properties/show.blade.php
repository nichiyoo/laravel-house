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

    <ul class="grid grid-cols-2 gap-4">
      @foreach ($property->amenities as $amenity)
        <x-amenity :amenity="$amenity" />
      @endforeach
    </ul>
  </div>
</x-detail-layout>
