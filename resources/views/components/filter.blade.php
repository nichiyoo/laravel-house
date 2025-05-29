@props([
    'route' => null,
])

@php
  use App\Enums\IntervalType;

  $intervals = IntervalType::cases();
@endphp

<div x-data="filter" x-init="$el.querySelector('button').addEventListener('click', (e) => {
    e.preventDefault();
    $dispatch('trigger', {
        route: @js($route)
    });
})">

  {{ $slot }}

  @once
    <div x-on:trigger.window="open($event.detail.route)">
      <x-modal name="filter-properties" focusable>
        <form method="GET" x-bind:action="route">
          <div class="grid gap-4 p-side">

            <div>
              <x-label for="query" value="Search property" />
              <x-input id="query" name="query" type="search" placeholder="Search property"
                value="{{ request()->get('query') }}" />
            </div>

            <div>
              <x-label for="interval" value="Payment" />
              <x-select id="interval" name="interval">
                <option value="" @selected(request()->get('interval') === null)>All</option>
                @foreach ($intervals as $interval)
                  <option value="{{ $interval->value }}" @selected(request()->get('interval') === $interval->value)>
                    {{ $interval->label() }}
                  </option>
                @endforeach
              </x-select>
            </div>

            <div>
              <x-label for="distance" value="Distance range" />
              <x-progress name="distance" min="0" max="30" step="1"
                value="{{ request()->get('distance', 10) }}" />
            </div>

            <div>
              <x-label for="price" value="Price range" />
              <x-range name="price" min="100000" max="5000000" step="100000"
                start="{{ request()->get('price_min', 100000) }}" end="{{ request()->get('price_max', 5000000) }}" />
            </div>

            <div>
              <x-label for="rating" value="Minimum Rating" />
              <x-progress name="rating" min="0" max="5" step="1"
                value="{{ request()->get('rating', 0) }}" />
            </div>
          </div>

          <div class="h-navbar border-t grid gap-4 grid-cols-2 p-4">
            <x-button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'filter-properties')">
              <i data-lucide="x" class="size-5"></i>
              <span>Cancel</span>
            </x-button>

            <x-button type="submit">
              <i data-lucide="list-filter" class="size-5"></i>
              <span>Apply</span>
            </x-button>
          </div>
        </form>
      </x-modal>
    </div>

    <script>
      document.addEventListener('alpine:init', () => {
        Alpine.data('filter', () => ({
          route: null,

          open(route) {
            this.route = route;
            this.$dispatch('open-modal', 'filter-properties');
          },
        }));
      });
    </script>
  @endonce
</div>
