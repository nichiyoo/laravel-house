<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Profile</x-slot>
      <x-slot:heading>Edit Profile</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('tenants.profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('tenants.profile.form', [
          'user' => Auth::user(),
          'tenant' => Auth::user()->tenant,
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Update Profile</span>
    </x-button>
  </div>
</x-app-layout>
