@php $saveManOn = \App\Models\Setting::get('saveman_enabled', '1') === '1'; @endphp
@if($saveManOn)

<div x-data="saveManWidget()" x-on:app:before-navigate.window="open = false" class="fixed bottom-5 right-5 z-[9999] [view-transition-name:save-man-widget]" style="font-family:'Segoe UI',Arial,sans-serif;">

    {{-- ── Floating button ──────────────────────────────────────── --}}
    <button @click="toggleChat()"
            x-show="!open"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75"
            title="Chat with Save Man"
            class="w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-105 transition-transform relative group cursor-pointer border-0"
            style="background:#0a2540;">

        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
            <rect x="3" y="6" width="18" height="13" rx="2" stroke="white" stroke-width="1.5" fill="none"/>
            <circle cx="8.5" cy="10.5" r="1" fill="white"/>
            <circle cx="15.5" cy="10.5" r="1" fill="white"/>
            <path d="M8 14.5s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M9 6V4.5a3 3 0 016 0V6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            <circle cx="12" cy="3" r="0.75" fill="white"/>
        </svg>

        {{-- Online pulse --}}
        <span class="absolute top-0.5 right-0.5 w-3.5 h-3.5 rounded-full bg-green-400 ring-2 ring-white flex items-center justify-center">
            <span class="absolute w-full h-full rounded-full bg-green-400 animate-ping opacity-60"></span>
        </span>

        {{-- Tooltip --}}
        <span class="absolute bottom-full right-0 mb-2 px-2.5 py-1 bg-gray-900 text-white text-xs rounded-lg whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
            Chat with Save Man
        </span>
    </button>

    {{-- ── Chat panel ───────────────────────────────────────────── --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden"
         style="width:340px;height:500px;border:1px solid #e5e7eb;">

        {{-- Header --}}
        <div class="flex items-center gap-3 px-4 py-3 flex-shrink-0" style="background:#0a2540;">
            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.12);">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <rect x="3" y="6" width="18" height="13" rx="2" stroke="white" stroke-width="1.5" fill="none"/>
                    <circle cx="8.5" cy="10.5" r="1" fill="white"/>
                    <circle cx="15.5" cy="10.5" r="1" fill="white"/>
                    <path d="M8 14.5s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M9 6V4.5a3 3 0 016 0V6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-white font-semibold text-sm leading-tight">Save Man</div>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                    <span class="text-xs" style="color:#93c5fd;">AI Assistant · TTSolutions</span>
                </div>
            </div>
            <button @click="open = false"
                    class="p-1.5 rounded-lg transition-colors cursor-pointer border-0"
                    style="background:transparent;color:rgba(255,255,255,0.5);"
                    onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Messages area --}}
        <div x-ref="msgs"
             class="flex-1 overflow-y-auto p-4"
             style="background:#f8faff;display:flex;flex-direction:column;gap:12px;">

            <template x-for="(msg, i) in messages" :key="i">
                <div :style="msg.role === 'user' ? 'display:flex;justify-content:flex-end;' : 'display:flex;justify-content:flex-start;align-items:flex-start;gap:8px;'">

                    {{-- AI avatar --}}
                    <div x-show="msg.role === 'assistant'"
                         class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background:#0a2540;margin-top:2px;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                            <rect x="3" y="6" width="18" height="13" rx="2" stroke="white" stroke-width="1.5" fill="none"/>
                            <circle cx="8.5" cy="10.5" r="1" fill="white"/>
                            <circle cx="15.5" cy="10.5" r="1" fill="white"/>
                            <path d="M8 14.5s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div :style="msg.role === 'user' ? 'max-width:82%;' : 'max-width:88%;'">
                        <div x-text="msg.text"
                             :style="msg.role === 'user'
                                ? 'background:#0a2540;color:#fff;border-radius:16px 16px 4px 16px;padding:9px 13px;font-size:13px;white-space:pre-line;line-height:1.55;'
                                : 'background:#fff;color:#1f2937;border-radius:16px 16px 16px 4px;padding:9px 13px;font-size:13px;white-space:pre-line;line-height:1.55;border:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,0.06);'">
                        </div>
                        <div x-text="msg.time"
                             :style="msg.role === 'user' ? 'font-size:10px;color:#9ca3af;margin-top:3px;text-align:right;' : 'font-size:10px;color:#9ca3af;margin-top:3px;padding-left:4px;'">
                        </div>
                    </div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="loading" style="display:flex;align-items:center;gap:8px;">
                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0" style="background:#0a2540;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                        <rect x="3" y="6" width="18" height="13" rx="2" stroke="white" stroke-width="1.5" fill="none"/>
                        <circle cx="8.5" cy="10.5" r="1" fill="white"/>
                        <circle cx="15.5" cy="10.5" r="1" fill="white"/>
                        <path d="M8 14.5s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div style="background:#fff;border-radius:16px 16px 16px 4px;padding:10px 14px;border:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,0.06);display:flex;gap:4px;align-items:center;height:36px;">
                    <span class="sm-dot"></span>
                    <span class="sm-dot" style="animation-delay:.15s"></span>
                    <span class="sm-dot" style="animation-delay:.3s"></span>
                </div>
            </div>

            {{-- Quick-action chips (shown before first user message) --}}
            <div x-show="!hasUserMessage && messages.length > 0 && !loading"
                 style="display:flex;flex-wrap:wrap;gap:7px;margin-top:4px;">
                <template x-for="q in quickQuestions" :key="q">
                    <button @click="quickAsk(q)"
                            x-text="q"
                            class="text-xs rounded-full px-3 py-1.5 cursor-pointer border transition-colors"
                            style="background:#fff;border-color:rgba(10,37,64,0.2);color:#0a2540;"
                            onmouseover="this.style.background='rgba(10,37,64,0.06)';this.style.borderColor='#0a2540';"
                            onmouseout="this.style.background='#fff';this.style.borderColor='rgba(10,37,64,0.2)';">
                    </button>
                </template>
            </div>
        </div>

        {{-- Input area --}}
        <div style="border-top:1px solid #e5e7eb;padding:12px;background:#fff;flex-shrink:0;">
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <textarea x-model="input"
                          @keydown.enter.prevent="if(!$event.shiftKey){ send(); }"
                          :disabled="loading"
                          x-ref="inputEl"
                          @input="autoResize($event.target)"
                          rows="1"
                          placeholder="Ask Save Man anything…"
                          style="flex:1;resize:none;border:1px solid #e5e7eb;border-radius:12px;padding:8px 12px;font-size:13px;font-family:inherit;min-height:38px;max-height:96px;overflow-y:auto;outline:none;transition:border-color .15s;line-height:1.45;"
                          onfocus="this.style.borderColor='#0a2540';this.style.boxShadow='0 0 0 3px rgba(10,37,64,0.1)';"
                          onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';"
                ></textarea>
                <button @click="send()"
                        :disabled="loading || !input.trim()"
                        class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center transition-colors border-0 cursor-pointer"
                        style="background:#0a2540;"
                        onmouseover="if(!this.disabled)this.style.background='#0d3b6e';"
                        onmouseout="this.style.background='#0a2540';"
                        :style="(loading || !input.trim()) ? 'opacity:.4;cursor:not-allowed;' : 'opacity:1;cursor:pointer;'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                </button>
            </div>
            <p style="text-align:center;font-size:10px;color:#d1d5db;margin-top:6px;margin-bottom:0;">Powered by TTSolutions Limited AI</p>
        </div>
    </div>
</div>

{{-- Typing dot animation --}}
<style>
.sm-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #9ca3af;
    display: inline-block; animation: smBounce .8s infinite ease-in-out;
}
@keyframes smBounce {
    0%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-6px); }
}
[x-cloak] { display: none !important; }
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('saveManWidget', () => ({
        open: false,
        messages: [],
        input: '',
        loading: false,
        quickQuestions: [
            'What services do you offer?',
            'How do I place an order?',
            'What are your payment methods?',
            'How can I contact you?'
        ],

        get hasUserMessage() {
            return this.messages.some(m => m.role === 'user');
        },

        now() {
            return new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        },

        toggleChat() {
            this.open = !this.open;
            if (this.open) {
                if (this.messages.length === 0) {
                    this.addWelcome();
                }
                this.$nextTick(() => {
                    this.scrollBottom();
                    this.$refs.inputEl?.focus();
                });
            }
        },

        addWelcome() {
            this.messages.push({
                role: 'assistant',
                text: "👋 Hi there! I'm Save Man, your AI assistant for TTSolutions Limited.\n\nI have live knowledge of our full product catalog and can help with:\n• Products & pricing\n• How to place an order\n• Payment methods & banking details\n• Project timelines\n• General inquiries\n\nWhat can I help you with today?",
                time: this.now()
            });
        },

        addMessage(role, text) {
            this.messages.push({ role, text, time: this.now() });
            this.$nextTick(() => this.scrollBottom());
        },

        async send() {
            const msg = this.input.trim();
            if (!msg || this.loading) return;

            this.input = '';
            this.$nextTick(() => {
                if (this.$refs.inputEl) {
                    this.$refs.inputEl.style.height = 'auto';
                }
            });

            this.addMessage('user', msg);
            this.loading = true;

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
                const history = this.messages
                    .slice(0, -1)
                    .slice(-12)
                    .map(m => ({ role: m.role, content: m.text }));

                const res = await fetch('/saveman/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({ message: msg, history })
                });

                if (res.status === 429) {
                    this.addMessage('assistant', "You're sending messages too quickly — please wait a moment. 😊");
                } else if (!res.ok) {
                    throw new Error('HTTP ' + res.status);
                } else {
                    const data = await res.json();
                    this.addMessage('assistant', data.reply || 'Sorry, something went wrong. Please try again.');
                }
            } catch (e) {
                this.addMessage('assistant', 'Connection issue — please try again shortly, or contact us at ttsl.support@gmail.com. 🙏');
            }

            this.loading = false;
        },

        quickAsk(q) {
            this.input = q;
            this.send();
        },

        scrollBottom() {
            const el = this.$refs.msgs;
            if (el) el.scrollTop = el.scrollHeight;
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 96) + 'px';
        }
    }));
});
</script>

@endif
