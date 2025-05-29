@props([
    'status' => null,
    'duration' => 3000,
    'variant' => 'success',
])

@php
  $props = $attributes
      ->merge([
          'class' => 'p-4 text-sm rounded-xl',
      ])
      ->class([
          'flex items-start gap-2',
          'bg-green-600 text-base-50' => $variant === 'success',
          'bg-yellow-600 text-base-50' => $variant === 'warning',
          'bg-red-600 text-base-50' => $variant === 'error',
          'bg-blue-600 text-base-50' => $variant === 'info',
      ]);
@endphp

@if ($status)
  <div x-data="{ show: true }" x-init="setTimeout(() => show = false, {{ $duration }})" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-5" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-5" class='fixed z-50 w-full max-w-md bottom-16 p-side'>

    <span {{ $props }}>
      @if ($variant === 'success')
        <i data-lucide="check-circle" class="size-5"></i>
      @elseif($variant === 'warning')
        <i data-lucide="alert-triangle" class="size-5"></i>
      @elseif($variant === 'error')
        <i data-lucide="x-circle" class="size-5"></i>
      @elseif($variant === 'info')
        <i data-lucide="info-circle" class="size-5"></i>
      @endif

      {{ $status }}
    </span>
  </div>
@endif
