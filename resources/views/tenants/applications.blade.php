@php
  use App\Enums\StatusType;
@endphp

<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Applications</x-slot>
      <x-slot:heading>Rental Applications</x-slot>
    </x-title>

    @forelse ($properties as $property)
      <a href="{{ route('tenants.properties.show', $property) }}" class="relative">
        <x-properties.card :property="$property">

          @php
            $details = (object) [
                'status' => $property->pivot->status->label(),
                'start' => $property->pivot->start->format('d M Y'),
                'total' => 'Rp ' . number_format($property->pivot->total),
                'method' => $property->pivot->method->label(),
                'duration' => $property->pivot->duration * $property->interval->ratio() . ' months',
                'created' => $property->pivot->created_at->diffForHumans(),
            ];
          @endphp

          <div class="border-t p-6 grid gap-1">
            @foreach ($details as $key => $value)
              <dl class="flex items-end gap-2 text-sm">
                <dt class="capitalize font-medium whitespace-nowrap">{{ $key }}</dt>
                <hr class="w-full border-b border-dashed border-base-300 mb-1">
                <dd class="whitespace-nowrap">{{ $value }}</dd>
              </dl>
            @endforeach
          </div>

          @if ($property->pivot->status == StatusType::PENDING)
            <div class="border-t grid grid-cols-2 text-sm font-medium">
              <form method="POST" action="{{ route('tenants.properties.cancel', $property) }}">
                @csrf
                <input type="hidden" name="id" value="{{ $property->pivot->id }}">
                <button class="px-6 py-4 flex items-center justify-center gap-2 bg-red-500 text-white w-full">
                  <span>Cancel</span>
                </button>
              </form>

              <a href="{{ route('tenants.properties.show', $property) }}"
                class="border-r px-6 py-4 flex items-center justify-center gap-2">
                <span>Chat</span>
              </a>
            </div>
          @endif
        </x-properties.card>
      </a>
    @empty
      <div class="flex flex-col justify-center gap-4 h-96">
        <div class="flex items-center justify-center gap-2 text-base-500">
          <span>Oops! No properties found.</span>
          <i data-lucide="search" class="size-4"></i>
        </div>
      </div>
    @endforelse
  </div>
</x-app-layout>
