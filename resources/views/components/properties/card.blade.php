@props([
    'property' => null,
    'transaction' => null,
])

@php
  use App\Enums\StatusType;
@endphp

<div class="card overflow-hidden">
  <div class="flex items-center justify-between gap-4 p-4">
    <x-profile :user="$property->owner->user" />

    @tenant
      <form method="POST" action="{{ route('tenants.properties.bookmark', $property) }}">
        @csrf
        <button size="icon" class="@if ($property->bookmarked) text-primary-500 @endif">
          <i data-lucide="bookmark" class="size-5 @if ($property->bookmarked) fill-current @endif"></i>
          <span class="sr-only">Bookmark</span>
        </button>
      </form>
    @endtenant
  </div>

  <div class="relative w-full aspect-video bg-base-100">
    <img src="{{ $property->backdrop ?? asset('images/property.jpg') }}" alt="{{ $property->name }}"
      class="object-cover size-full" />

    <div class="absolute inset-0 w-full p-6">
      <div class="flex items-center justify-between">
        <x-badge variant="primary">
          <x-rating rating="{{ $property->rating }}" size="small" />
        </x-badge>

        @tenant
          <x-badge variant="secondary">
            <span>{{ round($property->distance, 1) }} Km</span>
          </x-badge>
        @endtenant
      </div>
    </div>
  </div>

  <div class="grid gap-2 p-6">
    <div>
      <h3 class="font-medium">{{ $property->name }}</h3>
      <p class="text-sm truncate text-base-500">{{ $property->address }}</p>
    </div>
    <span class="text-primary-500">Rp {{ number_format($property->price) }}/month</span>
  </div>

  @if ($transaction)
    @php
      $details = (object) [
          'status' => $transaction->status->label(),
          'start' => $transaction->start->format('d M Y'),
          'total' => 'Rp ' . number_format($property->price * $transaction->duration * $property->interval->ratio()),
          'method' => $transaction->method->label(),
          'duration' => $transaction->duration * $property->interval->ratio() . ' months',
      ];
    @endphp

    <div class="border-t p-6 grid gap-1">
      @foreach ($details as $key => $value)
        <dl class="flex items-end gap-2 text-sm">
          <dt class="capitalize font-medium whitespace-nowrap">{{ $key }}</dt>
          <hr class="w-full border-b border-dashed mb-1">
          <dd class="whitespace-nowrap">{{ $value }}</dd>
        </dl>
      @endforeach
    </div>
  @endif

  @if ($transaction && $transaction->status == StatusType::PENDING)
    <div class="border-t grid grid-cols-2 text-sm font-medium">
      <form method="POST" action="{{ route('tenants.properties.cancel', $property) }}">
        @csrf
        <input type="hidden" name="id" value="{{ $transaction->id }}">
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
</div>
