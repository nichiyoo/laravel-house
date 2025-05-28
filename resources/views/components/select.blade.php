@props([
    'readonly' => false,
    'disabled' => false,
    'placeholder' => 'Select an option',
])

@php
  $props = $attributes
      ->class([
          'disabled:bg-base-200 disabled:text-base-500' => $disabled,
          'bg-base-50 text-base-500 focus:ring-0 focus:border-base-300' => $readonly,
      ])
      ->merge([
          'disabled' => $disabled,
          'readonly' => $readonly,
          'class' => 'text-sm p-3 border-base-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl w-full',
      ]);
@endphp

<select {{ $props }}>
  <option value="" disabled>{{ $placeholder }}</option>
  {{ $slot }}
</select>
