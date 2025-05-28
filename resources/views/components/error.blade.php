@props([
    'messages' => null,
])

@isset($messages)
  @foreach ($messages as $message)
    <span class="text-sm text-red-600">{{ $message }}</span>
  @endforeach
@endisset
