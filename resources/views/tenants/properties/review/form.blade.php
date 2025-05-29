<div class="grid gap-4 grid-cols-2">
  <div class="col-span-full">
    <x-label for="id" value="Rental" />
    <x-select id="id" name="id" value="{{ old('id') }}">
      @foreach ($rented as $rent)
        <option value="{{ $rent->pivot->id }}">
          {{ $rent->name }} - {{ $rent->pivot->duration }} {{ $rent->interval->unit() }}
        </option>
      @endforeach
    </x-select>
    <x-error :messages="$errors->get('id')" />
  </div>

  <div class="col-span-full">
    <x-label for="rating" value="Rating" />
    <x-progress id="rating" name="rating" value="{{ old('rating') }}" min="1" max="5" />
    <x-error :messages="$errors->get('rating')" />
  </div>

  <div class="col-span-full">
    <x-label for="review" value="Review" />
    <x-textarea id="review" name="review" placeholder="Write your review here..."
      rows="4">{{ old('review') }}</x-textarea>
    <x-error :messages="$errors->get('review')" />
  </div>
</div>
