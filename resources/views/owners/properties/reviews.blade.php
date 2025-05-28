<x-detail-layout :property="$property">
  <div class="grid items-start gap-6 min-h-80">
    @forelse ($property->tenants as $tenant)
      <div class="card">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <img src="{{ $tenant->avatar }}" alt="{{ $tenant->name }}" class="w-10 h-10 rounded-full">
          </div>
        </div>
      </div>
    @empty
      <div class="flex flex-col justify-center h-56 gap-4">
        <div class="flex items-center justify-center gap-2 text-zinc-500">
          <span>Oops! No review found.</span>
          <i data-lucide="search" class="size-4"></i>
        </div>
      </div>
    @endforelse
  </div>
</x-detail-layout>
