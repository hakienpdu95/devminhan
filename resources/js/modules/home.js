/**
 * home.js — Portal homepage only
 * Scroll reveal (.reveal) + counter animation ([data-count])
 * Load chỉ trên trang chủ qua @vite('resources/js/modules/home.js')
 */

/* Self-hosted font — Vite bundles woff2 files, font-display:swap via fontsource */
import '@fontsource/be-vietnam-pro/400.css';
import '@fontsource/be-vietnam-pro/500.css';
import '@fontsource/be-vietnam-pro/600.css';
import '@fontsource/be-vietnam-pro/700.css';
import '@fontsource/be-vietnam-pro/800.css';

function countUpNow(el) {
    el.textContent = parseFloat(el.getAttribute('data-count')).toLocaleString('vi-VN');
}

function countUp(el) {
    var target = parseFloat(el.getAttribute('data-count'));
    var start = null;
    var dur = 1300;

    function step(ts) {
        if (start === null) start = ts;
        var p = Math.min((ts - start) / dur, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(target * eased).toLocaleString('vi-VN');
        if (p < 1) requestAnimationFrame(step);
        else el.textContent = target.toLocaleString('vi-VN');
    }

    requestAnimationFrame(step);
}

function initHome() {
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('in'); });
        document.querySelectorAll('[data-count]').forEach(countUpNow);
        return;
    }

    // Reveal observer
    var ioReveal = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                ioReveal.unobserve(e.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    document.querySelectorAll('.reveal').forEach(function (el) { ioReveal.observe(el); });

    // Counter observer
    var ioCount = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                countUp(e.target);
                ioCount.unobserve(e.target);
            }
        });
    }, { threshold: 0.6 });

    document.querySelectorAll('[data-count]').forEach(function (el) { ioCount.observe(el); });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHome);
} else {
    initHome();
}
