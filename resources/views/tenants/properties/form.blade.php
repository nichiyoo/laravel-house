<div class="grid gap-4 grid-cols-2" x-data="{
    total: 0,
    months: 0,
    duration: @js(old('duration', 1)),
    currency: 'Rp 0',
    init() {
        this.update();
    },
    update() {
        this.months = this.duration * {{ $property->interval->ratio() }};
        this.total = {{ $property->price }} * this.months;
        this.currency = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(this.total);
    }
}">
  <div class="col-span-full">
    <x-label for="name" value="Full Name" />
    <x-input id="name" type="text" name="name" value="{{ Auth::user()->name }}" required readonly />
    <x-error :messages="$errors->get('name')" />
  </div>

  <div class="col-span-full">
    <x-label for="email" value="Email" />
    <x-input id="email" type="email" name="email" value="{{ Auth::user()->email }}" required readonly />
    <x-error :messages="$errors->get('email')" />
  </div>

  <div class="col-span-full">
    <x-label for="phone" value="Phone Number" />
    <x-input id="phone" type="tel" name="phone" value="{{ Auth::user()->phone }}" required readonly />
    <x-error :messages="$errors->get('phone')" />
  </div>

  <div class="col-span-full">
    <x-label for="start" value="Start Date" />
    <x-input id="start" type="date" name="start" value="{{ old('start') }}" required />
    <x-error :messages="$errors->get('start')" />
  </div>

  <div>
    <x-label for="duration" value="Duration ({{ $property->interval->unit() }})" />
    <x-input id="duration" type="number" name="duration" value="{{ old('duration') }}" required min="1"
      x-model="duration" x-on:input="update()" />
    <x-error :messages="$errors->get('duration')" />
  </div>

  <div>
    <x-label for="monthly" value="Duration in months" />
    <x-input id="monthly" type="text" name="monthly" x-bind:value="months + ' Month'" required readonly />
  </div>

  <div class="col-span-full">
    <x-label for="price" value="Total Price" />
    <x-input id="price" type="text" name="price" x-bind:value="currency" required readonly />
    <x-error :messages="$errors->get('price')" />
  </div>

  <div class="col-span-full">
    <x-label for="method" value="Payment Method" />
    <x-select id="method" name="method" required>
      @foreach ($methods as $method)
        <option value="{{ $method->value }}" {{ old('method') === $method->value ? 'selected' : '' }}>
          {{ $method->label() }}
        </option>
      @endforeach
    </x-select>
    <x-error :messages="$errors->get('method')" />
  </div>

  <div class="col-span-full">
    <x-label for="terms" value="Rental Terms" />
    <div class="text-sm text-base-600">
      <p>By submitting this form, you agree to the following terms:</p>

      <ul class="pl-5 list-disc list-inside">
        <li>A deposit equivalent to 1 month's rent</li>
        <li>Rent is due on the 1st of each month</li>
        <li>Minimum rental period is 6 months</li>
        <li>Utilities are not included in the rent</li>
      </ul>
    </div>

    <div class="flex items-start gap-2 mt-4">
      <input type="checkbox" id="agree_terms" name="agree_terms"
        class="mt-1 rounded shadow-sm border-base-300 text-primary-500 focus:border-primary-500 focus:ring-primary-500"
        required>
      <label for="agree_terms" class="text-sm">I agree to the rental terms and conditions</label>
    </div>
  </div>
</div>
