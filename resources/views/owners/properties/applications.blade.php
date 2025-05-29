@php
  use App\Enums\StatusType;
@endphp

<x-detail-layout :property="$property">
  <div class="grid gap-6 p-side">
    @forelse ($tenants as $tenant)
      <div class="card overflow-hidden">
        <div class="py-4 px-6">
          <x-profile :user="$tenant->user" />
        </div>

        @php
          $details = (object) [
              'status' => $tenant->pivot->status->label(),
              'start' => $tenant->pivot->start->format('d M Y'),
              'total' => 'Rp ' . number_format($tenant->pivot->total),
              'method' => $tenant->pivot->method->label(),
              'duration' => $tenant->pivot->duration * $property->interval->ratio() . ' months',
              'created' => $tenant->pivot->created_at->diffForHumans(),
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

        @if ($tenant->pivot->status == StatusType::PENDING)
          <div class="border-t grid grid-cols-2 text-sm font-medium">
            <form method="POST" action="{{ route('owners.properties.reject', $property) }}">
              @csrf
              <input type="hidden" name="id" value="{{ $tenant->pivot->id }}">
              <button class="px-6 py-4 flex items-center justify-center gap-2 bg-red-500 text-white w-full">
                <span>Reject</span>
              </button>
            </form>

            <form method="POST" action="{{ route('owners.properties.approve', $property) }}">
              @csrf
              <input type="hidden" name="id" value="{{ $tenant->pivot->id }}">
              <button class="px-6 py-4 flex items-center justify-center gap-2 bg-green-500 text-white w-full">
                <span>Approve</span>
              </button>
            </form>
          </div>
        @endif
      </div>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-detail-layout>
