@props([
    'readonly' => false,
    'disabled' => false,
])

@php
  $props = $attributes
      ->class([
          'disabled:bg-base-200 disabled:text-base-500' => $disabled,
          'bg-base-50 text-base-500 focus:ring-0 focus:border' => $readonly,
      ])
      ->merge([
          'disabled' => $disabled,
          'readonly' => $readonly,
          'class' => 'text-sm p-3 border-border focus:border-primary-500 focus:ring-primary-500 rounded-xl w-full',
      ]);
@endphp

<input {{ $props }} />
