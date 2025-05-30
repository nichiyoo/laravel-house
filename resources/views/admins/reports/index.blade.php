<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Reports</x-slot>
      <x-slot:heading>List of reports</x-slot>
      <x-slot:actions>
        <a href="{{ route('admins.reports.create') }}" class="btn btn-primary">
          <x-button size="icon">
            <i data-lucide="plus" class="size-5"></i>
            <span class="sr-only">Add report</span>
          </x-button>
        </a>
      </x-slot>
    </x-title>

    @forelse ($reports as $report)
      <div class="card overflow-hidden text-sm">
        <div class="py-4 px-6">
          <h2 class="font-medium">{{ $report->title }}</h2>
        </div>
        <div class="py-4 px-6 border-t">
          <p>{{ $report->description }}</p>
          <span class="text-base-500">{{ $report->date->format('M d, Y') }}</span>
        </div>
        <div class="grid grid-cols-2">
          <form method="POST" action="{{ route('admins.reports.destroy', $report) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="border-t text-sm px-6 py-4 flex items-center justify-center gap-2 bg-red-500 text-white w-full">
              Delete
            </button>
          </form>
          <a href="{{ route('admins.reports.edit', $report) }}"
            class="border-t text-sm px-6 py-4 flex items-center justify-center gap-2 bg-green-500 text-white w-full">
            Edit
          </a>
        </div>
      </div>
    @empty
      <x-empty />
    @endforelse

    {{ $reports->links() }}
  </div>
</x-app-layout>
