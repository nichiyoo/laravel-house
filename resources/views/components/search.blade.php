@props([
    'action' => null,
])

@php
  $props = $attributes->merge([
      'method' => 'GET',
      'action' => $action,
  ]);
@endphp

<form {{ $props }}>
  <div class="flex flex-col gap-2">
    <x-label for="query" value="Search property" class="sr-only" />

    <div class="relative">
      <x-input id="query" name="query" type="search" placeholder="Search property"
        value="{{ request()->get('query') }}" />

      <div class="absolute top-0 right-0 m-3">
        @if (!request()->get('query'))
          <button type="submit">
            <i data-lucide="search"></i>
            <span class="sr-only">Search</span>
          </button>
        @else
          <a href="{{ $action }}">
            <i data-lucide="x"></i>
            <span class="sr-only">Reset</span>
          </a>
        @endif
      </div>
    </div>

    <x-error :messages="$errors->get('query')" />
  </div>
</form>
