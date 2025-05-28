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
  <div class="mobile h-screen overflow-hidden relative">
    <main class="p-side h-content overflow-y-auto">
      {{ $slot }}
    </main>

    <nav class="h-navbar border-t bg-zinc-50 z-10 relative">
      <x-navbar />
    </nav>
  </div>

  @stack('scripts')
</body>

</html>
