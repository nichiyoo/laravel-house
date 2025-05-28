@props(['value'])

@php
  $props = $attributes->merge([
      'class' => 'block font-medium text-sm mb-1',
  ]);
@endphp

<label {{ $props }}>
  {{ $value ?? $slot }}
</label>
