@props([
    'rating' => null,
    'expanded' => false,
    'size' => 'default',
])

@php
  $rating = $rating ? round($rating, 1) : 'Not rated';
  $props = $attributes->merge([
      'class' => 'flex items-center gap-2',
  ]);

  $size = match ($size) {
      'small' => 'size-4',
      default => 'size-5',
  };
@endphp

<div {{ $props }}>
  @if ($expanded && (float) $rating > 0)
    <div class="flex items-center gap-0.5">
      @for ($i = 0; $i < floor((int) $rating); $i++)
        <i data-lucide="star" class="fill-current {{ $size }}"></i>
      @endfor
    </div>
  @else
    <i data-lucide="star" class="fill-current {{ $size }}"></i>
  @endif
  <span>{{ $rating }}</span>
</div>
