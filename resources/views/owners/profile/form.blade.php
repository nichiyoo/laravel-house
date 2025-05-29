<div class="grid gap-4 grid-cols-2">
  <div class="col-span-full">
    <x-label for="name" value="Name" />
    <x-input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" />
    <x-error :messages="$errors->get('name')" />
  </div>

  <div class="col-span-full">
    <x-label for="phone" value="Phone" />
    <x-input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" />
    <x-error :messages="$errors->get('phone')" />
  </div>

  <div class="col-span-full">
    <x-label for="avatar" value="Avatar" />
    <x-upload id="avatar" name="avatar" value="{{ old('avatar', $user->avatar) }}" placeholder="Change avatar" />
    <x-error :messages="$errors->get('avatar')" />
  </div>

  <div>
    <x-label for="password" value="Password" />
    <x-input id="password" name="password" type="password" />
    <x-error :messages="$errors->get('password')" />
  </div>

  <div>
    <x-label for="password_confirmation" value="Password Confirmation" />
    <x-input id="password_confirmation" name="password_confirmation" type="password" />
    <x-error :messages="$errors->get('password_confirmation')" />
  </div>
</div>
