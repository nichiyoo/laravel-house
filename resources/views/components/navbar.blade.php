@php
  use App\Enums\RoleType;

  $navigations = collect([
      [
          'label' => 'Home',
          'href' => route('dashboard'),
          'active' => request()->routeIs('*.dashboard'),
          'icon' => asset('icons/home.svg'),
          'color' => asset('icons/active/home.svg'),
          'show' => true,
      ],
      [
          'label' => 'Map',
          'href' => route('tenants.area'),
          'active' => request()->routeIs('tenants.area'),
          'icon' => asset('icons/map.svg'),
          'color' => asset('icons/active/map.svg'),
          'show' => Auth::user()->role == RoleType::TENANT,
      ],
      [
          'label' => 'Report',
          'href' => route('admins.reports.index'),
          'active' => request()->routeIs('admins.reports.index'),
          'icon' => asset('icons/post.svg'),
          'color' => asset('icons/active/post.svg'),
          'show' => Auth::user()->role == RoleType::ADMIN,
      ],
      [
          'href' => route('tenants.properties.index'),
          'active' => request()->routeIs('tenants.properties.index'),
          'label' => 'Search',
          'icon' => asset('icons/search.svg'),
          'color' => asset('icons/active/search.svg'),
          'show' => Auth::user()->role == RoleType::TENANT,
      ],
      [
          'label' => 'Post',
          'href' => route('owners.properties.create'),
          'active' => request()->routeIs('owners.properties.create'),
          'icon' => asset('icons/post.svg'),
          'color' => asset('icons/active/post.svg'),
          'show' => Auth::user()->role == RoleType::OWNER,
      ],
      [
          'href' => route('owners.properties.index'),
          'active' => request()->routeIs('owners.properties.index'),
          'label' => 'Manage',
          'icon' => asset('icons/manage.svg'),
          'color' => asset('icons/active/manage.svg'),
          'show' => Auth::user()->role == RoleType::OWNER,
      ],
      [
          'href' => route('admins.properties.unverified'),
          'active' => request()->routeIs('admins.properties.unverified'),
          'label' => 'Manage',
          'icon' => asset('icons/manage.svg'),
          'color' => asset('icons/active/manage.svg'),
          'show' => Auth::user()->role == RoleType::ADMIN,
      ],
      [
          'href' => route('notifications.index'),
          'active' => request()->routeIs('notifications.index'),
          'label' => 'Activity',
          'icon' => asset('icons/activity.svg'),
          'color' => asset('icons/active/activity.svg'),
          'show' => true,
      ],
      [
          'href' => route('profile'),
          'active' => request()->routeIs('*.profile'),
          'label' => 'Profile',
          'icon' => asset('icons/profile.svg'),
          'color' => asset('icons/active/profile.svg'),
          'show' => true,
      ],
  ])
      ->map(fn($item) => (object) $item)
      ->filter(fn($item) => $item->show);
@endphp

<ul class="grid grid-cols-5">
  @foreach ($navigations as $item)
    <li class="relative group h-navbar grid place-content-center" data-active="{{ $item->active ? 'true' : 'false' }}">

      <a href="{{ $item->href }}" class="flex flex-col items-center gap-2 group-data-[active='true']:text-primary-500">
        <x-svg src="{{ $item->active ? $item->color : $item->icon }}" />
        <span class="text-sm">{{ $item->label }}</span>
      </a>

      <div class="absolute bottom-0 w-2/3 h-1 group-data-[active='true']:block hidden left-1/2 -translate-x-1/2">
        <div class="size-full bg-primary-500 rounded-t-full"></div>
      </div>
    </li>
  @endforeach
</ul>
