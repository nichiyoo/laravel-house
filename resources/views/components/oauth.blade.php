<span class="text-sm text-center text-base-500">
  Or sign in with
</span>

@php
  use App\Enums\ProviderType;

  $providers = collect(ProviderType::cases())->map(
      fn(ProviderType $provider) => (object) [
          'name' => $provider->name,
          'route' => route('auth.redirect', $provider),
          'icon' => $provider->icon(),
      ],
  );
@endphp

<div class="flex items-center gap-2 justify-center">
  @foreach ($providers as $provider)
    <a href="{{ $provider->route }}" class="icon border rounded-full size-14 bg-base-50">
      <x-svg src="{{ $provider->icon }}" />
    </a>
  @endforeach
</div>
