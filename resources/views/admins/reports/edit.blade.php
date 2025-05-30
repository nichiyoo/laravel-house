<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Edit Report</x-slot>
      <x-slot:heading>{{ $report->title }}</x-slot>
    </x-title>

    <form id="form" method="POST" action="{{ route('admins.reports.update', $report) }}">
      @csrf
      @method('PUT')
      @include('admins.reports.form', [
          'report' => $report,
      ])
    </form>

    <x-button form="form" type="submit">
      <span>Update Report</span>
    </x-button>
  </div>
</x-app-layout>
