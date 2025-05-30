<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Add Report</x-slot>
      <x-slot:heading>Report Details</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('admins.reports.store') }}">
      @csrf
      @include('admins.reports.form', [
          'report' => new App\Models\Report(),
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Create Report</span>
    </x-button>
  </div>
</x-app-layout>
