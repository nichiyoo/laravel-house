<x-auth-layout>
  <form method="POST" action="{{ route('auth.login') }}" class="grid gap-4">
    @csrf

    <div>
      <x-label for="email" value="Email" />
      <x-input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
        autocomplete="username" placeholder="Enter your email" />
      <x-error :messages="$errors->get('email')" />
    </div>

    <div>
      <x-label for="password" value="Password" />
      <x-input id="password" type="password" name="password" required autocomplete="current-password"
        placeholder="Enter your password" />
      <x-error :messages="$errors->get('password')" />
    </div>

    <div class="flex items-center justify-end gap-4 text-sm">
      <a href="{{ route('auth.register') }}" class="text-primary-500">
        Create account
      </a>
    </div>

    <x-button>Log in</x-button>
    <x-oauth />
  </form>
</x-auth-layout>
