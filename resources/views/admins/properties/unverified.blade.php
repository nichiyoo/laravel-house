<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>properties</x-slot>
      <x-slot:heading>Unverified properties</x-slot>
    </x-title>

    <section>
      <x-search action="{{ route('admins.properties.unverified') }}" />
    </section>

    <section class="grid gap-4">
      <h2 class="font-medium">
        @if (request()->get('query'))
          Result for keywords "{{ request()->get('query') }}"
        @else
          properties
        @endif
      </h2>

      @forelse ($properties as $property)
        <a href="{{ route('admins.properties.show', $property) }}">
          <x-properties.card :property="$property">
            <form method="POST" action="{{ route('admins.properties.approve', $property) }}">
              @csrf
              <button
                class="px-6 py-4 flex items-center justify-center gap-2 bg-green-500 text-white w-full border-t text-sm">
                Approve
              </button>
            </form>
          </x-properties.card>
        </a>
      @empty
        <x-empty />
      @endforelse
    </section>
  </div>
</x-app-layout>
