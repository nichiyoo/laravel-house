<div class="grid gap-4 grid-cols-2">
  <div class="col-span-full">
    <x-label for="date" value="Date" />
    <x-input id="date" name="date" type="date"
      value="{{ old('date', $report->date ?? now()->format('Y-m-d')) }}" />
    <x-error :messages="$errors->get('date')" />
  </div>

  <div class="col-span-full">
    <x-label for="title" value="Title" />
    <x-input id="title" name="title" type="text" value="{{ old('title', $report->title) }}"
      placeholder="Report title" />
    <x-error :messages="$errors->get('title')" />
  </div>

  <div class="col-span-full">
    <x-label for="description" value="Description" />
    <x-textarea id="description" name="description"
      placeholder="Report description">{{ old('description', $report->description) }}</x-textarea>
    <x-error :messages="$errors->get('description')" />
  </div>

  <div class="col-span-full">
    <x-label for="recommendation" value="Recommendation" />
    <x-textarea id="recommendation" name="recommendation"
      placeholder="Report recommendation">{{ old('recommendation', $report->recommendation) }}</x-textarea>
    <x-error :messages="$errors->get('recommendation')" />
  </div>
</div>
