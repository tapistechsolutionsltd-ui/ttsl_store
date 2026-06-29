import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.start();

// Cart count updater
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});

async function updateCartCount() {
    try {
        const res = await fetch('/cart/count');
        const data = await res.json();
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = data.count;
            el.classList.toggle('hidden', data.count === 0);
        });
    } catch (e) {}
}

window.updateCartCount = updateCartCount;

// Flash message auto-hide
setTimeout(() => {
    document.querySelectorAll('.flash-message').forEach(el => {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 4000);

// Image preview for file inputs
document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    input.addEventListener('change', function () {
        const previewId = this.dataset.preview;
        const preview = document.getElementById(previewId);
        if (preview && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});

// Full-page navigation loader (navy overlay + spinner) — only shown if the
// next page takes a while to arrive (slow network, heavy route, etc).
// Fast navigations never see it: the page unloads before the delay timer fires.
(function () {
    const loader = document.getElementById('page-loader');

    const SHOW_DELAY_MS = 350;
    let showTimer = null;

    function scheduleShowLoader() {
        if (!loader) return;
        clearTimeout(showTimer);
        showTimer = setTimeout(function () {
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
        }, SHOW_DELAY_MS);
    }

    function hideLoader() {
        if (!loader) return;
        clearTimeout(showTimer);
        loader.classList.add('opacity-0', 'pointer-events-none');
        loader.classList.remove('opacity-100');
    }

    // Tell any open dropdown/menu/drawer/widget (header "All" menu, account menu,
    // mobile nav, shop filter drawer, chat widget) to close itself right away, so
    // the outgoing page isn't caught with an overlay open when the browser
    // captures/crossfades it into the next page.
    function closeOpenOverlays() {
        window.dispatchEvent(new CustomEvent('app:before-navigate'));
    }

    function isNavigatingClick(e) {
        if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return false;

        const link = e.target.closest('a[href]');
        if (!link || link.target === '_blank' || link.hasAttribute('download')) return false;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return false;
        if (link.origin !== window.location.origin) return false;
        if (link.pathname === window.location.pathname && link.hash) return false;

        return true;
    }

    document.addEventListener('click', function (e) {
        if (!isNavigatingClick(e)) return;
        closeOpenOverlays();
        scheduleShowLoader();
    });

    document.addEventListener('submit', function (e) {
        if (e.defaultPrevented || !(e.target instanceof HTMLFormElement)) return;
        closeOpenOverlays();
        scheduleShowLoader();
    });

    // Restore the page (e.g. back/forward navigation from the browser cache)
    window.addEventListener('pageshow', hideLoader);
})();
