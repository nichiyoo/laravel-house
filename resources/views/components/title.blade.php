@props([
    'section' => 'Section',
    'heading' => 'Heading',
])

<header>
  <span class="text-sm opacity-50">{{ $section }}</span>
  <h1 class="text-lg font-semibold line-clamp-1">
    {{ $heading }}
  </h1>
</header>
