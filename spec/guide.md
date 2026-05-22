Core Module - Đã implement

  Cấu trúc thư mục                                                                                                                                                    

  Modules/Core/
  ├── app/
  │   ├── Api/
  │   │   ├── DTO/ApiResponse.php          ← Chuẩn hóa mọi response từ CRM
  │   │   ├── Exceptions/ApiException.php  ← Exception handler cho API calls
  │   │   └── SanctumApiClient.php         ← HTTP client chính (singleton, retry, pool)
  │   ├── Bff/Aggregators/
  │   │   ├── BaseAggregator.php           ← Base với Cache::tags() + DI SanctumApiClient
  │   │   └── PageDataAggregator.php       ← Pool example: menu + settings trong 1 call
  │   ├── Caching/
  │   │   └── CacheManager.php             ← Flush/warm cache theo tags
  │   ├── Queries/
  │   │   └── BaseQuery.php                ← CQRS Query base với auto-cache
  │   ├── Security/
  │   │   ├── SecurityHeadersMiddleware.php ← CSP, X-Frame, HSTS, no fingerprint
  │   │   └── ApiTokenValidationMiddleware.php ← Block request nếu token chưa config
  │   └── Providers/CoreServiceProvider.php ← Register singletons + middleware aliases

  Config files tạo mới

  - config/bff.php — CRM URL, token, timeout, retry
  - config/security.php — CSP, HSTS, rate limit
  - config/theme.php — Available themes + master layout paths

  Nguyên tắc tuân thủ

  - SanctumApiClient dùng Http::pool() cho concurrent requests
  - Mọi response chuẩn hóa qua ApiResponse DTO
  - Cache dùng Cache::tags() để invalidate chính xác
  - Middleware đăng ký alias: security.headers, api.token
  - SecurityHeadersMiddleware tự động append vào web middleware stack

  .env cần thêm

  CRM_BASE_URL=https://your-crm.com
  CRM_API_TOKEN=your-token-here
  REDIS_HOST=127.0.0.1
  CACHE_STORE=redis

Theme Module - Đã implement

  Cấu trúc thư mục                                                                                                                                                    

  Modules/Theme/
  ├── app/
  │   ├── Actions/
  │   │   └── ResolveThemeAction.php        ← Laravel Action resolve theme theo priority
  │   ├── Http/Middleware/
  │   │   └── ResolveThemeMiddleware.php    ← Share $theme + $themeMaster vào tất cả views
  │   └── Providers/ThemeServiceProvider.php ← Register views, middleware alias 'theme'
  └── resources/views/
      ├── base/
      │   └── document.blade.php            ← HTML skeleton: SEO, OG, viewport, @yield
      ├── themes/
      │   ├── default/
      │   │   ├── layouts/master.blade.php  ← Container + header/footer
      │   │   └── partials/{header,footer}
      │   ├── modern/
      │   │   ├── layouts/master.blade.php  ← Sticky header, max-screen-xl
      │   │   └── partials/{header,footer}
      │   └── luxury/
      │       ├── layouts/master.blade.php  ← Dark bg, wide tracking
      │       └── partials/{header,footer}
      └── overrides/                        ← Module-level view overrides

  Cách dùng trong route/controller

  // Route với theme cụ thể
  Route::middleware(['theme:luxury'])->group(function () {
      Route::get('/campaign', CampaignController::class);
  });

  // Controller tự chọn theme theo page data
  public function show(Request $request, string $slug): View
  {
      $page = $this->aggregator->getPage($slug);
      $theme = $page->data['theme'] ?? null;

      app(ResolveThemeMiddleware::class)->handle($request, fn($r) => $r, $theme);

      return view('page::show', compact('page'));
  }

  {{-- Trong view của bất kỳ module nào --}}
  @extends($themeMaster)

  @section('title', 'Page Title')
  @section('content')
      <h1>Hello World</h1>
  @endsection

  Override priority

  1. $pageTheme từ controller/route param
  2. ?theme=xxx query param (chỉ local/dev)
  3. config('theme.default')