<x-app-layout>
  <div class="grid gap-6">
    <x-title>
      <x-slot:section>Help</x-slot>
      <x-slot:heading>Frequently Asked Questions</x-slot>
    </x-title>

    <p class="text-sm text-base-500">
      If you need help, please contact us at
      <a href="mailto:support@example.com" class="text-primary-500">support@example.com</a>.
    </p>

    @php
      $faqs = collect([
          [
              'question' => 'How do make a booking? ',
              'answer' =>
                  'To make a booking, you need to select the property you want to book, and then select the date you want to book.',
          ],
          [
              'question' => 'Do i need to pay a deposit?',
              'answer' =>
                  'Yes, you need to pay a deposit to make a booking. we will refund the deposit after the booking is completed.',
          ],
          [
              'question' => 'How do i cancel a booking?',
              'answer' => 'You can cancel a booking by accessing your booking and clicking the cancel button.',
          ],
          [
              'question' => 'How do i contact the property owner?',
              'answer' =>
                  'You can contact the property owner by accessing the property and clicking the contact owner button.',
          ],
          [
              'question' => 'Can i advertise my property on your platform?',
              'answer' =>
                  'Yes, you can advertise your property on our platform. Please contact us for more information.',
          ],
          [
              'question' => 'How do register as a property owner?',
              'answer' =>
                  'You can register as a property owner by accessing the register page and following the instructions.',
          ],
      ])->map(fn($item) => (object) $item);
    @endphp

    <div class="grid gap-4">
      @foreach ($faqs as $faq)
        <div class="card text-sm overflow-hidden" x-data="{ open: false }">
          <div x-on:click="open = !open" class="py-4 px-6 flex items-start justify-between cursor-pointer">
            <h3 class="font-medium">{{ $faq->question }}</h3>
            <i data-lucide="chevron-down" class="flex-none size-5" x-bind:class="open && 'rotate-180'"></i>
          </div>
          <div x-show="open" class="py-4 px-6 border-t" x-transition x-cloak>
            <p class="text-base-500">{{ $faq->answer }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</x-app-layout>
