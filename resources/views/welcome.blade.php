<x-landing-layout>
  <div class="p-side grid grid-rows-3 h-screen">
    <header class="font-bold">
      <span class="block text-xl">Selamat datang</span>
      <span class="block text-5xl text-primary-500">{{ config('app.name') }}.</span>
    </header>

    <div class="grid self-center gap-4 text-center">
      <x-logo class="max-w-xs mx-auto" />
      <p class="text-center">Temukan Kos Pilihanmu</p>
    </div>

    <div class="grid gap-2 self-end">
      <a href="{{ route('auth.login') }}"><x-button variant="secondary">Are you a user?</x-button></a>
      <a href="{{ route('auth.login') }}"><x-button variant="primary">Are you an owner?</x-button></a>
    </div>
  </div>
</x-landing-layout>
