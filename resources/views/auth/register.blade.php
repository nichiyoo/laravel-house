<x-auth-layout>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-5xl font-bold">Register</h1>
    <a href="{{ route('auth.redirect', ['provider' => 'google']) }}" class="btn btn-primary">Register with Google</a>
    <a href="{{ route('auth.redirect', ['provider' => 'github']) }}" class="btn btn-secondary">Register with Github</a>
  </div>
</x-auth-layout>
