<x-app-layout>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-5xl font-bold">Welcome to Laravel House</h1>
    @auth
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
    @else
      <a href="{{ route('auth.login') }}" class="btn btn-primary">Login</a>
      <a href="{{ route('auth.register') }}" class="btn btn-secondary">Register</a>
    @endauth
  </div>
</x-app-layout>
