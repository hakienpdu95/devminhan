import { defineConfig } from 'vite';
import laravel          from 'laravel-vite-plugin';
import { bunny }        from 'laravel-vite-plugin/fonts';
import tailwindcss      from '@tailwindcss/vite';

export default defineConfig(({ mode }) => ({

    plugins: [
        laravel({
            input: [
                /* ── Base app ── */
                'resources/css/app.css',
                'resources/js/app.js',

                /* ── Theme SCSS — mỗi theme ra 1 file CSS riêng ── */
                'Modules/Theme/resources/scss/theme-default.scss',
                'Modules/Theme/resources/scss/theme-modern.scss',
                'Modules/Theme/resources/scss/theme-luxury.scss',
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'Modules/**/resources/views/**/*.blade.php',
                'Modules/**/resources/scss/**/*.scss',
                'routes/**/*.php',
            ],
            fonts: [
                bunny('Instrument Sans', { weights: [400, 500, 600] }),
            ],
        }),
        tailwindcss(),
    ],

    css: {
        /* Source map bật trong dev, tắt trong prod */
        devSourcemap: mode !== 'production',

        preprocessorOptions: {
            scss: {
                /* Dart Sass modern compiler API (sass-embedded >= 1.79) */
                api: 'modern-compiler',
                /* Tắt warning từ third-party deps */
                quietDeps: true,
            },
        },
    },

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },

}));
