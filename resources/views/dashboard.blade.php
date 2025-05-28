<x-app-layout>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-5xl font-bold">Dashboard</h1>
    <span>Hello {{ Auth::user()->name }}</span>
    <span>Your role is {{ Auth::user()->role->label() }}</span>
  </div>
</x-app-layout>
