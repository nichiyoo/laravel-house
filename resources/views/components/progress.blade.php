@props([
    'min' => 0,
    'max' => 1000,
    'step' => 1,
    'name' => 'value',
    'value' => null,
])

<div x-data="{
    minLimit: {{ $min }},
    maxLimit: {{ $max }},
    value: null,
    init() {
        this.value = this.clamp({{ $value }}) || this.minLimit;
    },
    clamp(val) {
        return Math.max(this.minLimit, Math.min(this.maxLimit, val));
    },
    updateValue(e) {
        this.value = this.clamp(e.target.value);
    },
    percent() {
        return ((this.value - this.minLimit) / (this.maxLimit - this.minLimit)) * 100;
    },
}" class="w-full">
  <div class="relative w-full h-10">
    <div class="absolute left-0 z-0 w-full h-2 rounded-full top-4 bg-base-200"></div>
    <div class="absolute z-10 h-2 rounded-full top-4 bg-primary-500"
      x-bind:style="{
          width: percent() + '%'
      }">
    </div>

    <input type="range" x-bind:min="minLimit" x-bind:max="maxLimit" step="{{ $step }}"
      x-model="value" x-on:input="updateValue"
      class="absolute left-0 z-20 w-full h-2 bg-transparent appearance-none top-4 range-thumb" />
  </div>

  <div class="mt-4">
    <input type="number" name="{{ $name }}" x-bind:value="value" x-on:input="updateValue"
      class="w-full p-3 text-sm border-border focus:border-primary-500 focus:ring-primary-500 rounded-xl" />
  </div>
</div>
