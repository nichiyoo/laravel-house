<x-auth-layout>
  <form method="POST" action="{{ route('auth.register') }}" class="grid gap-4">
    @csrf

    <div>
      <x-label for="name" value="Name" />
      <x-input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
        autocomplete="name" placeholder="Enter your name" />
      <x-error :messages="$errors->get('name')" />
    </div>

    <div>
      <x-label for="email" value="Email" />
      <x-input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
        placeholder="Enter your email" />
      <x-error :messages="$errors->get('email')" />
    </div>

    <div>
      <x-label for="role" value="Role" />
      <x-select id="role" name="role" required autocomplete="role" placeholder="Select your role">
        @foreach ($roles as $role)
          <option value="{{ $role }}" @selected(request()->get('role') == $role->value ?? old('role') == $role->value)>
            {{ $role->label() }}
          </option>
        @endforeach
      </x-select>
      <x-error :messages="$errors->get('role')" />
    </div>

    <div>
      <x-label for="password" value="Password" />
      <x-input id="password" type="password" name="password" required autocomplete="new-password"
        placeholder="Enter your password" />
      <x-error :messages="$errors->get('password')" />
    </div>

    <div>
      <x-label for="password_confirmation" value="Confirm Password" />
      <x-input id="password_confirmation" type="password" name="password_confirmation" required
        autocomplete="new-password" placeholder="Confirm your password" />
      <x-error :messages="$errors->get('password_confirmation')" />
    </div>

    <div class="flex items-center justify-end gap-4 text-sm">
      <a href="{{ route('auth.login') }}" class="text-primary-500">
        Already have an account?
      </a>
    </div>

    <x-button>Create account</x-button>

    <x-oauth />
  </form>
  </x-guest-layout>
