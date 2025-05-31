<x-detail-layout :property="$property">
  <div class="grid gap-6 p-side">
    @forelse ($reviews as $review)
      <div class="card overflow-hidden">
        <div class="py-4 px-6">
          <x-profile :user="$review->user" />
        </div>
        <div class="border-t p-6">
          <p class="text-sm text-base-500">{{ $review->pivot->review }}</p>
        </div>
        <div class="border-t py-4 px-6 flex items-center justify-between">
          <x-rating class="text-primary-500" :rating="$review->pivot->rating" expanded size="small" />
          <span class="text-sm text-base-500">
            {{ $review->pivot->created_at->diffForHumans() }}
          </span>
        </div>
      </div>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-detail-layout>
