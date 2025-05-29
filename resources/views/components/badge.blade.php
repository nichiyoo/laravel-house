@props([
    'variant' => 'primary',
])

@php
  $props = $attributes
      ->class([
          'text-yellow-400 bg-base-50' => $variant == 'primary',
          'text-base-900 bg-base-50' => $variant == 'secondary',
          'text-green-400 bg-base-50' => $variant == 'success',
          'text-red-400 bg-base-50' => $variant == 'danger',
      ])
      ->merge([
          'class' => 'flex items-center gap-2 px-2 py-1 rounded-full text-xs font-medium',
      ]);
@endphp

<span {{ $props }}>
  {{ $slot }}
</span>
