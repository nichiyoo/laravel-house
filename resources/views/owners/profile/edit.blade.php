<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Profile</x-slot>
      <x-slot:heading>Edit Profile</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('owners.profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('owners.profile.form', [
          'user' => Auth::user(),
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Update Profile</span>
    </x-button>
  </div>
</x-app-layout>
