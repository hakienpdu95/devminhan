# ARCHITECTURE — Frontend Portal (devminhan)

> Implementation reference for the architecture defined in `spec/architecture.md`.
> Last updated: 2026-05-22.

## 1. Overview

Public-facing portal built on **Laravel 13** that consumes a CRM via REST API (Sanctum token). No shared database, no GraphQL.

### Architecture stack
- **Advanced Vertical Slice Architecture (AVSA)** — feature/business slice, not horizontal layers.
- **CQRS-lite** — separation of read (Query) and write (Action) paths.
- **Laravel Modules** (`nwidart/laravel-modules`) — each feature is an isolated module.
- **Laravel Actions** (`lorisleiva/laravel-actions`) — business logic encapsulated as Actions.
- **BFF Pattern** — `Modules/Core/Bff/Aggregators/` aggregates multiple CRM calls into one.
- **Cache-first** — Redis + Cache Tags, with graceful degradation to file driver.

## 2. Module layout

```
Modules/
├── Core/                       Infrastructure: BFF, Security, Cache, API client
│   └── app/
│       ├── Api/
│       │   ├── SanctumApiClient.php       # HTTP client, retry, pool support
│       │   ├── DTO/ApiResponse.php        # Normalized CRM response
│       │   └── Exceptions/ApiException.php
│       ├── Bff/Aggregators/
│       │   ├── BaseAggregator.php         # Cache + sanitization base
│       │   └── PageDataAggregator.php     # Example: menu + settings via pool()
│       ├── Caching/CacheManager.php       # Tag-aware cache wrapper
│       ├── Queries/BaseQuery.php          # CQRS read base
│       ├── Actions/                       # CQRS write/business logic
│       ├── Security/
│       │   ├── SecurityHeadersMiddleware.php
│       │   ├── ApiTokenValidationMiddleware.php
│       │   └── RateLimitMiddleware.php    # per-IP + per-user
│       └── Providers/CoreServiceProvider.php
│
└── Theme/                      DaisyUI-native theme + layout system
    ├── app/
    │   ├── Actions/ResolveThemeAction.php       # resolve theme (color) + layout (structure)
    │   └── Http/Middleware/ResolveThemeMiddleware.php
    └── resources/
        └── views/
            ├── base/document.blade.php          # HTML skeleton: <html data-theme>, SEO, @vite
            ├── layouts/                         # Layout masters (structure) — extend base
            │   ├── app.blade.php                #   navbar + container + footer
            │   ├── landing.blade.php            #   full-bleed marketing
            │   └── minimal.blade.php            #   bare centered shell
            ├── partials/
            │   ├── navbar.blade.php             # DaisyUI navbar + nav
            │   ├── footer.blade.php             # DaisyUI footer
            │   └── theme-switcher.blade.php     # Alpine runtime data-theme switcher
            └── overrides/                       # Module-level view overrides
```

**Styling is DaisyUI-only.** Colors/shape come from DaisyUI themes (the `data-theme`
attribute), declared in `resources/css/app.css`:
- two custom brand themes — `brand-light` (default) + `brand-dark` — via `@plugin "daisyui/theme"`;
- a curated set of built-in themes enabled via `@plugin "daisyui" { themes: ... }`.

All themes compile into a single CSS bundle; switching is just changing one attribute.
There is **no hand-rolled SCSS token layer** — components use DaisyUI classes
(`navbar`, `card`, `btn`, `input`…) and semantic utilities (`bg-base-100`, `text-base-content`,
`btn-primary`). Page-specific CSS that DaisyUI doesn't cover (e.g. the survey shell)
lives in `resources/css/app.css`.

## 3. Design rules (must follow)

1. Controllers only dispatch to Query/Aggregator — no logic.
2. All CRM API calls go through `Bff/Aggregators` or `Api/SanctumApiClient`.
3. Cache uses `Cache::tags()` where supported; `BaseAggregator::remember()` degrades gracefully.
4. Theme/view is configurable per route via `theme:<name>` middleware.
5. Security logic centralized in `Modules/Core/app/Security/`.
6. Every CRM response is normalized via `ApiResponse` DTO.
7. **Input from URL params (slug, id) must be sanitized via `BaseAggregator::sanitizeSlug()` / `sanitizeId()`** before being interpolated into a CRM URL.

## 4. Security

- Sanctum API token in `CRM_API_TOKEN` env. Never hardcoded.
- `ApiTokenValidationMiddleware` blocks requests early (HTTP 503) if token missing.
- `SecurityHeadersMiddleware` sets CSP, X-Frame-Options, Referrer-Policy, Permissions-Policy, HSTS (opt-in), strips fingerprinting headers.
- `RateLimitMiddleware` — per-IP + per-user, configurable via `config/security.php`.
- All aggregator inputs that flow into URLs are sanitized.
- Logging is endpoint/status only; never bodies or tokens.

## 5. Performance

- BFF aggregators use `Http::pool()` to parallelize CRM calls.
- Cache via `Cache::tags()` (Redis in production) for surgical invalidation.
- Single CSS bundle (Tailwind v4 + DaisyUI, minified by `oxc`) covering all themes
  (~140 KB, ~25 KB gzipped) — switching themes loads no extra CSS.
- Per-library JS chunks (`manualChunks`) cache independently across deploys.

## 6. Theme + layout system

Two **independent** axes, both registered in `config/theme.php`:

| Axis | What it controls | How it's chosen | Value |
|------|------------------|-----------------|-------|
| **Theme** | colors / shape | `data-theme` attribute | a DaisyUI theme name |
| **Layout** | page structure (navbar/footer/container) | Blade `@extends` | a master view path |

`ResolveThemeMiddleware` shares three variables with every view:
`$theme` (active data-theme), `$themes` (selectable list for the switcher),
`$themeMaster` (default layout master for the route).

**Theme resolution priority** (`ResolveThemeAction`):
per-route param → visitor cookie (switcher) → `?theme=` (local only) → `config('theme.default')`.

**Per-route selection:**
```php
// Default theme + default layout:
Route::get('/', HomeController::class);

// Override theme for a group:
Route::middleware('theme:luxury')->group(fn () => Route::get('/blog', BlogController::class));

// Override theme AND layout:
Route::middleware('theme:luxury,landing')->group(...);
Route::middleware('theme:,minimal')->group(...);   // layout only, default theme
```

**In a view** — use the route default layout, or pick one explicitly:
```blade
@extends($themeMaster)                 {{-- route default --}}
@extends('theme::layouts.landing')     {{-- explicit --}}
```

**Runtime switching:** the `theme-switcher` partial (Alpine `themeSwitcher`) sets
`<html data-theme>`, persists to `localStorage` + a cookie so the next SSR matches
(no flash). An inline anti-FOUC script in `base/document.blade.php` reconciles the
stored choice before first paint.

**Add a color theme:**
1. Custom → add a `@plugin "daisyui/theme" { name: "<name>"; … }` block in `resources/css/app.css`.
   Built-in → add its name to the `@plugin "daisyui" { themes: … }` list.
2. Register it in `config/theme.php` → `themes` (drives the switcher + validation).
3. Rebuild assets.

**Add a layout:**
1. Create `Modules/Theme/resources/views/layouts/<name>.blade.php` extending `theme::base.document`.
2. Register it in `config/theme.php` → `layouts`.

## 7. Environment requirements

| Env var | Purpose | Default |
|---------|---------|---------|
| `CRM_BASE_URL` | CRM API root | empty (required) |
| `CRM_API_TOKEN` | Sanctum token | empty (required) |
| `CRM_TIMEOUT` | HTTP timeout (s) | 10 |
| `CRM_RETRY_TIMES` | Retry count | 2 |
| `CACHE_STORE` | `redis` (prod) / `file` (dev) | `file` |
| `THEME_DEFAULT` | Default `data-theme` value | `brand-light` |
| `SECURITY_HSTS` | Enable HSTS header | `false` |
| `RATE_LIMIT_PER_MINUTE` | Per-IP requests/min | 60 |
| `RATE_LIMIT_BURST` | Extra allowance for auth users | 10 |

## 8. Build & deploy

Frontend assets are built with **`vite.config.frontend.js`** → `public/build/frontend`.
`AppServiceProvider::boot()` calls `Vite::useBuildDirectory('build/frontend')` so the
`@vite` directive reads that manifest.

```bash
composer install --optimize-autoloader --no-dev
npm ci && npm run build:frontend   # → public/build/frontend (minified by oxc)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Local dev: `npm run dev:frontend` (Vite HMR on port 5174).

For Redis cache tags in production:
```env
CACHE_STORE=redis
REDIS_CLIENT=predis     # or phpredis if PHP extension is installed
```

## 9. Verified behavior (last audit: 2026-06-01)

- ✅ DaisyUI-native themes: `/` → `brand-light`, `/blog`+`/contact` → `luxury` (HTTP 200, `data-theme` rendered).
- ✅ Single CSS bundle compiles all themes via `npm run build:frontend` (~140 KB / ~25 KB gzip).
- ✅ `@vite` reads `build/frontend` manifest (via `Vite::useBuildDirectory`).
- ✅ Theme switcher injects the full theme list (`window.__themes`) + cookie name for runtime switching.
- ✅ Layout/theme separation: `app` / `landing` / `minimal` masters all extend `base.document`.
- ✅ Security headers + rate limiting active on all web responses.
- ✅ Input sanitization + HTTP pool retained in `PageDataAggregator`.
- ✅ Cache layer degrades gracefully when tag support unavailable.
