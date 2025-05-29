<x-detail-layout :property="$property">
  <div class="grid gap-6 p-side">
    @forelse ($reviews as $review)
      <div class="card p-side grid gap-4">
        <div class="flex items-center justify-between">
          <x-profile :user="$review->user" />
          <x-rating :rating="$review->pivot->rating" />
        </div>
        <p class="text-base-500">{{ $review->pivot->review }}</p>
      </div>
    @empty
      <x-empty />
    @endforelse
  </div>
</x-detail-layout>
