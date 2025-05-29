@props([
    'name' => 'modal',
    'show' => false,
])

<div x-data="modal" x-trap.inert.noscroll="show" x-on:open-modal.window="open" x-on:close-modal.window="close"
  x-on:keydown.escape.window="show = false" x-show="show" class="fixed inset-0 z-50 grid items-end" x-cloak>

  <div x-show="show" class="fixed inset-0 transition-all" x-on:click="show = false"
    x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-base-950/50"></div>
  </div>

  <div x-cloak class="rounded-t-3xl w-full transform transition-transform max-w-md mx-auto bg-base-50" x-show="show"
    x-transition:enter="ease-out duration-200" x-transition:enter-start="translate-y-20"
    x-transition:enter-end="translate-y-0" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-20" x-on:click.outside="show = false">
    {{ $slot }}
  </div>
</div>

@once
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('modal', () => ({
        name: @js($name),
        show: @js($show),

        open(event) {
          if (event.detail === this.name) this.show = true;
        },

        close(event) {
          if (event.detail === this.name) this.show = false;
        }
      }));

      window.openModal = (name) => {
        window.dispatchEvent(
          new CustomEvent('open-modal', {
            detail: name
          })
        )
      }

      window.closeModal = (name) => {
        window.dispatchEvent(
          new CustomEvent('close-modal', {
            detail: name
          })
        )
      }
    });
  </script>
@endonce
