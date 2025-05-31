@php
  use App\Enums\VerificationType;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel House') }}</title>

  <!-- metadata -->
  <meta name="description" content="Laravel House is a platform for managing your home.">

  <!-- vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div class="mobile h-screen overflow-hidden relative">
    <x-status variant="success" status="{{ session('success') }}" />
    <x-status variant="error" status="{{ session('error') }}" />

    <div class="absolute top-0 w-full aspect-square">
      <img src="{{ $property->backdrop }}" alt="{{ $property->name }}" class="object-cover size-full" />
      <div class="absolute inset-0 bg-gradient-to-t from-base-950 to-transparent"></div>
    </div>

    <main class="h-content overflow-y-auto relative">
      <div class="grid gap-6">
        <div class="p-side pb-16 flex flex-col justify-between aspect-square text-base-50">
          <div class="flex items-center justify-between gap-2">
            <a href="{{ route('admins.properties.unverified') }}">
              <x-button size="icon">
                <i data-lucide="chevron-left" class="size-5"></i>
                <span class="sr-only">Back</span>
              </x-button>
            </a>
          </div>

          <div class="flex items-center justify-between">
            <x-profile :user="$property->owner->user" />

            <div class="flex gap-2 items-center">
              <a href="{{ route('chats.show', $property->owner->user) }}">
                <x-button size="icon" variant="secondary">
                  <i data-lucide="message-circle" class="size-5"></i>
                  <span class="sr-only">Chat</span>
                </x-button>
              </a>

              <a href="{{ route('admins.properties.tour', $property) }}">
                <x-button size="icon" variant="secondary">
                  <i data-lucide="camera" class="size-5"></i>
                  <span class="sr-only">Virtual Tour</span>
                </x-button>
              </a>
            </div>
          </div>
        </div>

        <section class="grid bg-base-50 rounded-t-3xl -mt-16">
          <div class="flex flex-col py-6 overflow-hidden p-side">
            <span class="text-sm text-base-400">Detail</span>
            <h2 class="truncate text-2xl font-semibold">
              {{ $property->name }}
            </h2>

            <span class="truncate text-base-500">{{ $property->address }}</span>

            <div class="flex items-center justify-between mt-2">
              <x-rating class="text-primary-500" rating="{{ $property->rating }}" expanded />
              <x-currency :amount="$property->price" />
            </div>
          </div>

          <div class="grid border-y">
            @php
              $tabs = collect([
                  [
                      'label' => 'Detail',
                      'route' => route('tenants.properties.show', $property),
                      'active' => request()->routeIs('tenants.properties.show', $property),
                  ],
              ])->map(fn($tab) => (object) $tab);
            @endphp

            @foreach ($tabs as $tab)
              <div class="flex items-center justify-center p-4">
                <a href="{{ $tab->route }}" class="@if ($tab->active) text-primary-500 @endif">
                  <span>{{ $tab->label }}</span>
                </a>
              </div>
            @endforeach
          </div>

          <div class="min-h-96">
            {{ $slot }}
          </div>
        </section>
      </div>
    </main>

    <nav class="h-navbar border-t bg-base-50">
      <div class="grid gap-4 grid-cols-2 p-4">
        @php
          $actions = collect([
              [
                  'label' => 'Back',
                  'route' => route('admins.properties.unverified'),
                  'icon' => 'arrow-left',
                  'variant' => 'secondary',
                  'show' => $property->verification === VerificationType::VERIFIED,
              ],
              [
                  'label' => 'Location',
                  'route' => route('admins.properties.location', $property),
                  'icon' => 'map',
                  'variant' => 'primary',
                  'show' => true,
              ],
          ])->map(fn($action) => (object) $action);
        @endphp

        @if ($property->verification === VerificationType::UNVERIFIED)
          <form action="{{ route('admins.properties.approve', $property) }}" method="POST">
            @csrf
            <x-button type="submit" variant="success">
              <i data-lucide="check" class="size-5"></i>
              <span>Approve</span>
            </x-button>
          </form>
        @endif

        @foreach ($actions as $action)
          @continue(!$action->show)

          <a href="{{ $action->route }}">
            <x-button variant="{{ $action->variant }}">
              <i data-lucide="{{ $action->icon }}" class="size-5"></i>
              <span>{{ $action->label }}</span>
            </x-button>
          </a>
        @endforeach
      </div>
    </nav>
  </div>
</body>

</html>
