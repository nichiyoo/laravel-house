<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel House') }}</title>

  <!-- metadata -->
  <meta name="description" content="Laravel House is a platform for managing your home.">

  <!-- vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div class="h-screen overflow-hidden mobile">
    <x-status variant="success" status="{{ session('success') }}" />
    <x-status variant="error" status="{{ session('error') }}" />

    <main class="relative h-content overflow-y-auto @if ($padding) p-side @endif">
      {{ $slot }}
    </main>

    <nav class="relative z-10 border-t h-navbar bg-base-50">
      <x-navbar />
    </nav>
  </div>

  @stack('scripts')
</body>

</html>
