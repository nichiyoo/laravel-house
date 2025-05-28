@props([
    'amount' => null,
])

<span class="font-medium">Rp {{ number_format($amount, 0, ',', '.') }}</span>
