/**
 * vite.config.frontend.js
 *
 * Laravel 13 | Vite 8 | Tailwind 4 | DaisyUI 5 | Alpine 3
 * ─────────────────────────────────────────────────────────────────────
 *
 * CHIẾN LƯỢC BUNDLE
 * ┌────────────────────────────────────────────────────────────────┐
 * │ CORE  (tải trên MỌI trang)                                     │
 * │  · app.css  → Tailwind 4 + DaisyUI 5 + layout CSS              │
 * │  · app.js   → Alpine 3 shell                                    │
 * ├────────────────────────────────────────────────────────────────┤
 * │ MODULES  (tải riêng theo trang — @vite() trong blade)           │
 * │  · toastify    toast notification      (nhẹ, nhiều trang)      │
 * │  · tom-select  select/autocomplete     (form)                   │
 * │  · swiper      carousel/slider                                  │
 * │  · qrcode      QR code generator                                │
 * └────────────────────────────────────────────────────────────────┘
 *
 * LỆNH:
 *   npm run dev:frontend    → vite --config vite.config.frontend.js
 *   npm run build:frontend  → vite build --config vite.config.frontend.js
 *
 * BLADE:
 *   @vite(['resources/css/app.css', 'resources/js/app.js'])
 *   @vite(['resources/js/modules/swiper.js'])
 */

import { defineConfig } from 'vite';
import laravel          from 'laravel-vite-plugin';
import tailwindcss      from '@tailwindcss/vite';
import path             from 'path';

/* ─── Tên file JS output (entry points) ─── */
const JS_OUTPUT = {
  'app':          'assets/app.[hash].js',
  'toastify':     'assets/toastify.[hash].js',
  'tom-select':   'assets/tom-select.[hash].js',
  'swiper':       'assets/swiper.[hash].js',
  'qrcode':       'assets/qrcode.[hash].js',
  'ai-readiness': 'assets/ai-readiness.[hash].js',
};

/* ─── Tên file CSS output ─── */
const CSS_OUTPUT = {
  'app.css':          'assets/app.[hash].css',
  'survey.css':       'assets/survey.[hash].css',
  'tom-select.css':   'assets/tom-select.[hash].css',
  'swiper.css':       'assets/swiper.[hash].css',
  'toastify.css':     'assets/toastify.[hash].css',
};

export default defineConfig(({ mode }) => {
  const isProd = mode === 'production';

  return {

    /* ── Base URL ──────────────────────────────────────── */
    base: isProd ? '/build/frontend/' : '/',

    /* ── Plugins ───────────────────────────────────────── */
    plugins: [
      /*
       * Tailwind CSS v4 (vite-native, không cần postcss/tailwind.config.js).
       * Đặt TRƯỚC laravel() để CSS pipeline đúng thứ tự.
       */
      tailwindcss(),

      /* Laravel Vite Plugin */
      laravel({
        input: [
          /* CORE */
          'resources/css/app.css',
          'resources/js/app.js',
          /* SURVEY — load only on survey pages */
          'resources/css/survey.css',
          /* MODULES */
          'resources/js/modules/toastify.js',
          'resources/js/modules/tom-select.js',
          'resources/js/modules/swiper.js',
          'resources/js/modules/qrcode.js',
          'resources/js/modules/ai-readiness.js',
        ],
        refresh: [
          'resources/views/**/*.blade.php',
          'Modules/**/resources/views/**/*.blade.php',
          'resources/css/**/*.css',
          'resources/js/**/*.js',
          'routes/**/*.php',
        ],
        buildDirectory: 'build/frontend',
        modulePreload:  { polyfill: true },
      }),
    ],

    /* ── Aliases ───────────────────────────────────────── */
    resolve: {
      alias: {
        '@':        path.resolve(__dirname, 'resources'),
        '@css':     path.resolve(__dirname, 'resources/css'),
        '@js':      path.resolve(__dirname, 'resources/js'),
        '@modules': path.resolve(__dirname, 'resources/js/modules'),
      },
    },

    /* ── Build ─────────────────────────────────────────── */
    build: {
      outDir:               'public/build/frontend',
      manifest:             'manifest.json',
      emptyOutDir:          true,
      sourcemap:            false,
      reportCompressedSize: true,
      chunkSizeWarningLimit: 500,

      /*
       * Vite 8 dùng rolldown + oxc làm bundler/minifier mặc định.
       *  · 'oxc'    = built-in Vite 8, nhanh, không cần cài thêm  ← DÙNG
       *  · 'esbuild'= deprecated Vite 8, gây lỗi transformWithEsbuild  ✗
       *  · 'terser' = optional, cần: npm install -D terser             ✗
       */
      minify:    'oxc',
      cssMinify: 'oxc',
      cssCodeSplit: true,

      rollupOptions: {
        output: {

          /* Entry file names */
          entryFileNames: (chunk) =>
            JS_OUTPUT[chunk.name] ?? `assets/${chunk.name}.[hash].js`,

          /* Shared chunk names */
          chunkFileNames: (chunk) => {
            const map = {
              'vendor-alpine':     'assets/vendor-alpine.[hash].js',
              'vendor-daisyui':    'assets/vendor-daisyui.[hash].js',
              'vendor-swiper':     'assets/vendor-swiper.[hash].js',
              'vendor-tom-select': 'assets/vendor-tom-select.[hash].js',
              'vendor-toastify':   'assets/vendor-toastify.[hash].js',
              'vendor-qrcode':     'assets/vendor-qrcode.[hash].js',
            };
            return map[chunk.name] ?? `assets/chunk-${chunk.name}.[hash].js`;
          },

          /* CSS + fonts + images */
          assetFileNames: (asset) => {
            const name = asset.name ?? '';
            if (/\.(woff2?|ttf|eot)$/.test(name))
              return 'assets/fonts/[name].[hash].[ext]';
            if (/\.svg$/.test(name) && /font|icon/i.test(name))
              return 'assets/fonts/[name].[hash].[ext]';
            if (/\.(png|jpe?g|gif|webp|avif|ico)$/.test(name))
              return 'assets/images/[name].[hash].[ext]';
            return CSS_OUTPUT[name] ?? 'assets/[name].[hash].[ext]';
          },

          /*
           * manualChunks: mỗi vendor thư viện → 1 chunk riêng.
           * → Browser cache độc lập từng thư viện.
           * → Chỉ thay đổi app code → vendor chunks KHÔNG re-download.
           *
           * Lưu ý: daisyui v5 là CSS-only (import qua Tailwind v4),
           * chunk này sẽ không match JS — không gây lỗi, chỉ unused.
           */
          manualChunks(id) {
            if (id.includes('node_modules/alpinejs'))        return 'vendor-alpine';
            if (id.includes('node_modules/daisyui'))         return 'vendor-daisyui';
            if (id.includes('node_modules/swiper'))          return 'vendor-swiper';
            if (id.includes('node_modules/tom-select'))      return 'vendor-tom-select';
            if (id.includes('node_modules/toastify-js'))     return 'vendor-toastify';
            if (id.includes('node_modules/qrcode-generator'))return 'vendor-qrcode';
            if (id.includes('node_modules/echarts') || id.includes('node_modules/zrender'))
                                                             return 'vendor-echarts';
          },
        },
      },
    },

    /* ── Dev server ────────────────────────────────────── */
    server: {
      /*
       * Dùng port 5174 để tránh conflict với vite.config.js (5173).
       * laravel-vite-plugin tự detect port này và inject đúng vào blade.
       */
      port:        5174,
      strictPort:  true,
      hmr:  { host: 'localhost' },
      watch:{ usePolling: false },
    },

    /* ── optimizeDeps (pre-bundle trong dev) ───────────── */
    optimizeDeps: {
      /* Pre-bundle: CORE packages → dev start nhanh */
      include: [
        'alpinejs',
        'toastify-js',
      ],
      /* Không pre-bundle: load lazy per-page */
      exclude: [
        'swiper',
        'tom-select',
        'qrcode-generator',
      ],
    },

  };
});
