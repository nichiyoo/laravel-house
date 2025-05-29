@props([
    'min' => 0,
    'max' => 1000,
    'step' => 1,
    'name' => 'value',
    'start' => null,
    'end' => null,
])

<div x-data="{
    minLimit: {{ $min }},
    maxLimit: {{ $max }},
    minValue: null,
    maxValue: null,
    init() {
        this.minValue = this.clamp({{ $start }}) || this.minLimit;
        this.maxValue = this.clamp({{ $end }}) || this.maxLimit;
    },
    clamp(val) {
        return Math.max(this.minLimit, Math.min(this.maxLimit, val));
    },
    updateMin(e) {
        this.minValue = Math.min(e.target.value, Math.min(this.maxLimit, this.maxValue - 1));
    },
    updateMax(e) {
        this.maxValue = Math.max(this.minValue, Math.min(this.maxLimit, e.target.value));
    },
    percent(val) {
        return ((val - this.minLimit) / (this.maxLimit - this.minLimit)) * 100;
    },
}" class="w-full">
  <div class="relative w-full h-10">
    <div class="absolute left-0 z-0 w-full h-2 rounded-full top-4 bg-base-200"></div>
    <div class="absolute z-10 h-2 rounded-full top-4 bg-primary-500"
      x-bind:style="{
          left: percent(minValue) + '%',
          width: (percent(maxValue) - percent(minValue)) + '%'
      }">
    </div>

    <input type="range" x-bind:min="minLimit" x-bind:max="maxLimit" step="{{ $step }}"
      x-model="minValue" x-on:input="updateMin"
      class="absolute left-0 z-20 w-full h-2 bg-transparent appearance-none pointer-events-none top-4 range-thumb" />

    <input type="range" x-bind:min="minLimit" x-bind:max="maxLimit" step="{{ $step }}"
      x-model="maxValue" x-on:input="updateMax"
      class="absolute left-0 z-30 w-full h-2 bg-transparent appearance-none pointer-events-none top-4 range-thumb" />
  </div>

  <div class="flex gap-4 mt-4">
    <input type="number" name="{{ $name }}_min" x-bind:value="minValue" x-on:input="updateMin"
      class="w-full p-3 text-sm focus:border-primary-500 focus:ring-primary-500 rounded-xl" />

    <input type="number" name="{{ $name }}_max" x-bind:value="maxValue" x-on:input="updateMax"
      class="w-full p-3 text-sm focus:border-primary-500 focus:ring-primary-500 rounded-xl" />
  </div>
</div>
