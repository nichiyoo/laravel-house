@props([
        //
    ])

@php
  $props = $attributes->merge([
      'class' => 'w-full',
  ]);
@endphp

<div {{ $props }}>
  <img src={{ asset('images/logo.png') }} alt="Logo" class="mx-auto">
</div>
