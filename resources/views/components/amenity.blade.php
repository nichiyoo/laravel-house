@props([
    'amenity' => null,
])

<li class="flex items-center p-3 gap-4 card text-sm font-medium">
  <i data-lucide="{{ $amenity->icon() }}" class="size-5"></i>
  <div class="truncate">{{ $amenity->label() }}</div>
</li>
