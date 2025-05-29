@props([
    'section' => 'Section',
    'heading' => 'Heading',
])

<header class="flex items-center justify-between gap-4">
  <div>
    <span class="text-sm opacity-50">{{ $section }}</span>
    <h1 class="text-lg font-semibold line-clamp-1">
      {{ $heading }}
    </h1>
  </div>

  @isset($actions)
    <div class="flex-none">
      {{ $actions }}
    </div>
  @endisset
</header>
