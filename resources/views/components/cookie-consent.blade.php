<div x-data="cookieConsent()" x-init="init()" x-cloak
     x-show="visible"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed bottom-0 left-0 right-0 z-[9998] bg-brand-dark text-white border-t border-white/10 shadow-2xl">
    <div class="max-w-screen-2xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center gap-4">
        <div class="flex-1 text-sm text-gray-300 leading-relaxed">
            We use cookies to keep you signed in, remember your cart, and improve your shopping experience on TTSolutions Limited.
            By continuing to browse, you agree to our use of cookies. Read our
            <a href="{{ route('privacy') }}" class="text-white underline hover:text-accent-light">Privacy Policy</a>
            and
            <a href="{{ route('terms') }}" class="text-white underline hover:text-accent-light">Terms of Service</a>.
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <button @click="decline()"
                class="text-xs sm:text-sm font-semibold px-4 py-2 rounded-lg border border-white/30 hover:bg-white/10 transition-colors whitespace-nowrap">
                Decline
            </button>
            <button @click="accept()"
                class="text-xs sm:text-sm font-bold px-5 py-2 rounded-lg bg-accent hover:bg-accent-dark transition-colors whitespace-nowrap">
                Accept Cookies
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cookieConsent', () => ({
        visible: false,

        init() {
            if (!this.getCookie('cookie_consent')) {
                this.visible = true;
            }
        },

        accept() {
            this.setConsent('accepted');
        },

        decline() {
            this.setConsent('declined');
        },

        setConsent(value) {
            this.setCookie('cookie_consent', value, 365);
            this.visible = false;
        },

        setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = name + '=' + value + '; expires=' + expires + '; path=/; SameSite=Lax';
        },

        getCookie(name) {
            return document.cookie
                .split('; ')
                .find(row => row.startsWith(name + '='))
                ?.split('=')[1];
        }
    }));
});
</script>
