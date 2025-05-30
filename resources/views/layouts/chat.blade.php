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
  <div class="relative h-screen overflow-hidden mobile">
    <main class="overflow-y-auto h-content" id="container">
      {{ $slot }}
    </main>

    <nav class="relative z-10 grid gap-2 border-t h-navbar bg-base-50">
      {{ $action }}
    </nav>
  </div>

  @stack('scripts')
</body>

</html>
