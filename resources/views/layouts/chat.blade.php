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
    <main class="h-content overflow-y-auto" id="container">
      {{ $slot }}
    </main>

    <nav class="h-navbar border-t bg-base-50 z-10 relative grid gap-2">
      {{ $action }}
    </nav>
  </div>

  @stack('scripts')
</body>

</html>
