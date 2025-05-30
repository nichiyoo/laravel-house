@props([
    'mine' => false,
    'content' => null,
    'time' => null,
])

<div class="flex group w-full" data-align="{{ $mine ? 'right' : 'left' }}">
  <div
    class="flex flex-col border min-w-40 max-w-sm rounded-2xl p-3 bg-base-50 group-data-[align=right]:ml-auto group-data-[align=left]:rounded-bl-none group-data-[align=right]:rounded-br-none">
    <p class="text-sm">{{ $content }}</p>
    <p class="text-xs text-base-400">{{ $time }}</p>
  </div>
</div>
