@props([
    'rating' => null,
    'expanded' => false,
])

<div class="flex items-center gap-2 text-yellow-500">
  @if ($expanded && (float) $rating > 0)
    <div class="flex items-center gap-0.5">
      @for ($i = 0; $i < floor((int) $rating); $i++)
        <i data-lucide="star" class="fill-current size-5"></i>
      @endfor
    </div>
  @else
    <i data-lucide="star" class="fill-current size-5"></i>
  @endif

  <span>{{ round((float) $rating, 1) }}</span>
</div>
