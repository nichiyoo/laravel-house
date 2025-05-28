@props([
    'user' => null,
    'status' => 'Status',
])

<div class="flex items-center gap-2">
  <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full" />

  <div class="text-sm">
    <div class="font-medium">{{ $user->name }}</div>
    <div class="text-base-500">{{ $user->role->label() }}</div>
  </div>
</div>
