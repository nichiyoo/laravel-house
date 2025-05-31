@props([
    'variant' => 'primary',
])

@php
  $props = $attributes
      ->class([
          'text-base-50 bg-primary-500' => $variant == 'primary',
          'text-base-900 bg-base-50' => $variant == 'secondary',
          'text-base-50 bg-green-500' => $variant == 'success',
          'text-base-50 bg-red-500' => $variant == 'destructive',
      ])
      ->merge([
          'class' => 'flex items-center gap-2 px-2 py-1 rounded-full text-xs font-medium',
      ]);
@endphp

<span {{ $props }}>
  {{ $slot }}
</span>
