@props([
    'src' => null,
])

@php
  $path = public_path($src);
  $content = file_get_contents($src);
@endphp

@if ($content)
  {!! $content !!}
@endif
