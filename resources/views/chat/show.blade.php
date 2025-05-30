<x-chat-layout>
  <div class="absolute top-0 flex items-center w-full border-b h-navbar px-side bg-base-50">
    <x-title>
      <x-slot:section>Messages</x-slot>
      <x-slot:heading>Chat with
        {{ $chat->sender_id === Auth::user()->id ? $chat->receiver->name : $chat->sender->name }}
      </x-slot>
    </x-title>
  </div>

  <div class="grid gap-6 pt-28 p-side">
    <div id="messages" class="grid gap-4">
      @foreach ($messages as $message)
        <x-message :mine="$message->user_id === Auth::user()->id">
          <x-slot:content>{{ $message->content }}</x-slot:content>
          <x-slot:time>{{ $message->created_at->format('H:i') }}</x-slot:time>
        </x-message>
      @endforeach
    </div>
  </div>

  <x-slot:action>
    <form id="form" class="flex items-center gap-2 p-4">
      <x-input type="text" id="input" placeholder="Type your message..." />
      <div class="flex-none">
        <x-button size="icon">
          <i data-lucide="send" class="size-5"></i>
          <span class="sr-only">send</span>
        </x-button>
      </div>
    </form>
  </x-slot:action>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.Echo === 'undefined') {
          console.error('Echo is not initialized');
          return;
        }

        const chat = {
          elements: {
            form: document.getElementById('form'),
            input: document.getElementById('input'),
            messages: document.getElementById('messages'),
            container: document.getElementById('container'),
          },

          config: {
            id: {{ $chat->id }},
            user: {{ Auth::user()->id }},
          },

          init() {
            this.scrollToBottom();

            this.elements.form.addEventListener('submit', (e) => {
              e.preventDefault();
              const content = this.elements.input.value.trim();
              if (!content) return;
              this.sendMessage(content);
            });

            window.Echo.private('chat.{{ $chat->id }}').listen('.message.sent', (e) => {
              console.log('test');
              this.addMessage(e.message);
            });
          },

          scrollToBottom() {
            this.elements.container.scrollTo({
              top: this.elements.container.scrollHeight,
              behavior: 'smooth'
            });
          },

          formatDate(date) {
            return new Intl.DateTimeFormat('en-US', {
              hour: '2-digit',
              minute: '2-digit'
            }).format(new Date(date));
          },

          createMessageHtml(message) {
            const own = message.user.id === this.config.user;
            return `
              <div class="flex w-full group" data-align="${own ? 'right' : 'left'}">
                <div class="flex flex-col border min-w-40 max-w-sm rounded-2xl p-3 bg-base-50 group-data-[align=right]:ml-auto group-data-[align=left]:rounded-bl-none group-data-[align=right]:rounded-br-none">
                  <p class="text-sm">${message.content}</p>
                  <p class="text-xs text-base-400">${this.formatDate(message.created_at)}</p>
                </div>
              </div>\
            `
          },

          addMessage(message) {
            this.elements.messages.insertAdjacentHTML('beforeend', this.createMessageHtml(message));
            this.scrollToBottom();
          },

          async sendMessage(content) {
            try {
              const result = await axios.post('/chats/{{ $chat->id }}' + '/send', {
                content
              });
              this.addMessage(result.data.message);
              this.elements.input.value = '';
            } catch (error) {
              console.error('error sending message:', error);
            }
          },
        };

        chat.init();
      });
    </script>
  @endpush
</x-chat-layout>
