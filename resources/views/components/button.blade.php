@props([
    'type' => 'submit',
    'size' => 'default',
    'variant' => 'primary',
])

@php
  $props = $attributes
      ->class([
          'transition ease-in-out duration-150',
          'flex items-center justify-center gap-2',
          'h-12 px-6 py-3' => $size === 'default',
          'size-12 aspect-square' => $size === 'icon',
          'border-transparent bg-primary-500 text-base-50 both:bg-primary-600' => $variant === 'primary',
          'border-transparent bg-base-200 text-base-900 both:bg-base-300' => $variant === 'secondary',
          'border-transparent bg-red-500 text-base-50 both:bg-red-600' => $variant === 'destructive',
          'border-transparent bg-green-500 text-base-50 both:bg-green-600' => $variant === 'success',
      ])
      ->merge([
          'type' => $type,
          'class' => 'flex-none w-full justify-center border rounded-xl text-sm font-medium focus:outline-none',
      ]);
@endphp

<button {{ $props }}>
  {{ $slot }}
</button>
