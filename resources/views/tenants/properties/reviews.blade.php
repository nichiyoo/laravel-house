<x-detail-layout :property="$property">
  <div class="grid gap-6 p-side overflow-hidden">
    @forelse ($property->tenants as $tenant)
      <div class="card p-side grid gap-4">
        <div class="flex items-center justify-between">
          <x-profile :user="$tenant->user" />
          <x-rating :rating="$tenant->pivot->rating" />
        </div>
        <p class="text-zinc-500">{{ $tenant->pivot->review }}</p>
      </div>
    @empty
    @endforelse
  </div>
</x-detail-layout>
