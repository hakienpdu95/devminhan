import Alpine from 'alpinejs';

// ── Theme switcher ──────────────────────────────────────────────────────────
// Switches the DaisyUI `data-theme` at runtime and persists the choice to both
// localStorage (instant, anti-FOUC) and a cookie (so SSR matches next request).
// Theme list is injected server-side via window.__themes (config/theme.php).
Alpine.data('themeSwitcher', () => ({
    current: document.documentElement.getAttribute('data-theme') || 'brand-light',

    get themes() {
        const raw = window.__themes || {};
        return Object.entries(raw).map(([value, meta]) => ({
            value,
            label:  meta.label  || value,
            scheme: meta.scheme || 'light',
        }));
    },

    get groups() {
        const out = {};
        for (const t of this.themes) (out[t.scheme] ||= []).push(t);
        return out;
    },

    get label() {
        return this.themes.find(t => t.value === this.current)?.label || this.current;
    },

    apply(value) {
        this.current = value;
        document.documentElement.setAttribute('data-theme', value);
        try { localStorage.setItem('theme', value); } catch (e) {}
        const name = window.__themeCookie || 'theme';
        document.cookie = `${name}=${value};path=/;max-age=31536000;samesite=lax`;
        document.activeElement?.blur();
    },
}));

window.Alpine = Alpine;
Alpine.start();
