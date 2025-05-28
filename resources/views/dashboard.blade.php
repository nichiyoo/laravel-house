<x-app-layout>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-5xl font-bold">Dashboard</h1>
    <span>Hello {{ Auth::user()->name }}</span>
  </div>
</x-app-layout>
