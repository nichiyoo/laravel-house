<x-auth-layout>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-5xl font-bold">Login</h1>
    <a href="{{ route('auth.redirect', ['provider' => 'google']) }}" class="btn btn-primary">Login with Google</a>
    <a href="{{ route('auth.redirect', ['provider' => 'github']) }}" class="btn btn-secondary">Login with Github</a>
  </div>
</x-auth-layout>
