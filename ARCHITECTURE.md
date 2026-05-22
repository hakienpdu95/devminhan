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
└── Theme/                      Multi-theme view + SCSS system
    ├── app/
    │   ├── Actions/ResolveThemeAction.php
    │   └── Http/Middleware/ResolveThemeMiddleware.php
    └── resources/
        ├── views/
        │   ├── base/document.blade.php    # HTML skeleton
        │   ├── themes/{default,modern,luxury}/layouts/master.blade.php
        │   └── overrides/                 # Module-level view overrides
        └── scss/                          # Token-first / 5-layer SCSS
            ├── tokens/        # CSS custom properties (color, space, type, motion)
            ├── tools/         # SCSS mixins + functions (zero CSS output)
            ├── themes/        # Per-theme :root overrides
            ├── ui/            # Visual styles — use var() only
            ├── pages/         # Page-specific styles
            └── theme-{default,modern,luxury}.scss  # Entry points
```

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
- Vite production build minifies SCSS via `oxc`; output ~23 KB/theme (~4.5 KB gzipped).
- Per-theme CSS file → no unused styles loaded.

## 6. Theme system

`config/theme.php` registers available themes. Default theme set via `THEME_DEFAULT` env.

**Per-page selection:**
```php
// All routes get the default theme:
Route::get('/', HomeController::class);

// Override for a route group:
Route::middleware('theme:luxury')->group(function () {
    Route::get('/blog', BlogController::class);
});
```

The `ResolveThemeMiddleware` shares `$theme` and `$themeMaster` with all views.

**Add a new theme:**
1. Create `Modules/Theme/resources/scss/themes/_<name>.scss` (token overrides).
2. Create `Modules/Theme/resources/scss/theme-<name>.scss` (entry point).
3. Create `Modules/Theme/resources/views/themes/<name>/layouts/master.blade.php`.
4. Register in `config/theme.php`.
5. Add to `vite.config.js` input array.

## 7. Environment requirements

| Env var | Purpose | Default |
|---------|---------|---------|
| `CRM_BASE_URL` | CRM API root | empty (required) |
| `CRM_API_TOKEN` | Sanctum token | empty (required) |
| `CRM_TIMEOUT` | HTTP timeout (s) | 10 |
| `CRM_RETRY_TIMES` | Retry count | 2 |
| `CACHE_STORE` | `redis` (prod) / `file` (dev) | `file` |
| `THEME_DEFAULT` | Default theme name | `default` |
| `SECURITY_HSTS` | Enable HSTS header | `false` |
| `RATE_LIMIT_PER_MINUTE` | Per-IP requests/min | 60 |
| `RATE_LIMIT_BURST` | Extra allowance for auth users | 10 |

## 8. Build & deploy

```bash
composer install --optimize-autoloader --no-dev
npm ci && npm run build           # Vite production: minified CSS + JS
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

For Redis cache tags in production:
```env
CACHE_STORE=redis
REDIS_CLIENT=predis     # or phpredis if PHP extension is installed
```

## 9. Verified behavior (last audit: 2026-05-22)

- ✅ Multi-theme works: `/` → default, `/blog`+`/contact` → luxury (HTTP 200, correct CSS classes).
- ✅ SCSS minified: 3 entry points → 3 distinct CSS files (~23 KB each, 1 line).
- ✅ Security headers applied on all web responses.
- ✅ Rate limiting active (per-IP + per-user).
- ✅ Input sanitization in `PageDataAggregator::getPage()`.
- ✅ HTTP pool used in `PageDataAggregator::getGlobalData()`.
- ✅ Cache layer degrades gracefully when tag support unavailable.
