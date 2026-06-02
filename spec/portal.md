# Portal Interface — Đặc tả tổng quát

> Tiền đề tham khảo khi xây dựng cổng thông tin đầy đủ (blog, menu, contact, landing pages…).
> Bổ sung cho `ARCHITECTURE.md` và `spec/architecture.md` — không thay thế.

---

## 1. Trạng thái hiện tại

| Điểm | Hiện trạng |
|------|-----------|
| Route `/` | `ai-readiness.blade.php` — blank layout, thuchoc theme |
| Route `/ai-readiness` | Alias của `/`, cùng blade |
| Route `/blog`, `/contact` | Placeholder blade — không có controller/aggregator thực |
| Layout survey | `blank` — page tự quản nav/footer bên trong blade |
| `app.js` | **0.73 kB** — chỉ `themeSwitcher` + `Alpine.start()` |
| `app.css` | **138 dòng** — DaisyUI themes + brand tokens + `[x-cloak]` |
| `survey.css` | **6.3 kB** — CSS riêng survey, chỉ load trên `/ai-readiness` |
| `ai-readiness.js` | **15.9 kB** — Alpine component + ECharts, chỉ load trên `/ai-readiness` |

Survey và portal đã được **tách biệt hoàn toàn** tại tầng asset — không có code nào của survey xuất hiện trên trang portal và ngược lại.

---

## 2. Nguyên tắc tách biệt asset (áp dụng cho mọi trang)

> **Core load mọi trang — Page asset chỉ load trang đó.**

```
app.css   ← DaisyUI config + brand/thuchoc themes + [x-cloak]   → MỌI trang
app.js    ← Alpine shell + themeSwitcher                         → MỌI trang
               │
               ├── survey.css        → chỉ /ai-readiness
               ├── ai-readiness.js   → chỉ /ai-readiness
               │
               ├── home.css          → chỉ trang chủ portal (nếu có animation/hero đặc biệt)
               ├── home.js           → chỉ trang chủ portal (swiper carousel, counter…)
               │
               ├── blog.css          → chỉ /blog, /blog/{slug} (nếu cần style bài viết)
               ├── blog.js           → chỉ /blog (swiper related posts, reading progress…)
               │
               └── toastify.js       → /contact và bất kỳ trang có form notification
```

**Cách load trong blade** — mỗi trang khai báo trong `@section('head_extra')`:

```blade
{{-- blog/index.blade.php --}}
@section('head_extra')
    @vite(['resources/css/blog.css', 'resources/js/modules/blog.js'])
@endsection

{{-- ai-readiness.blade.php --}}
@section('head_extra')
    @vite('resources/css/survey.css')
    @vite('resources/js/modules/ai-readiness.js')
@endsection
```

**Quy tắc:**
- Nếu trang chỉ dùng DaisyUI class + Tailwind utility thuần → **không cần CSS riêng**, `app.css` là đủ.
- Nếu trang có custom class ngoài DaisyUI (animation, layout đặc thù, font riêng…) → tạo `<page>.css` riêng.
- Nếu trang không có JS tương tác (chỉ render server-side) → **không cần JS riêng**, Alpine core là đủ.
- Nếu trang cần thư viện nặng (Swiper, ECharts, TomSelect…) → tạo `<page>.js` riêng, lazy import bên trong.

---

## 3. Đăng ký asset trong `vite.config.frontend.js`

Mỗi cặp CSS/JS page mới cần khai báo ở hai chỗ:

```js
// JS_OUTPUT — đặt tên chunk output
const JS_OUTPUT = {
  'app':          'assets/app.[hash].js',
  'ai-readiness': 'assets/ai-readiness.[hash].js',
  'home':         'assets/home.[hash].js',       // ← thêm khi build trang chủ portal
  'blog':         'assets/blog.[hash].js',        // ← thêm khi build blog
  // toastify, swiper, tom-select, qrcode — giữ nguyên
};

// CSS_OUTPUT — đặt tên chunk output
const CSS_OUTPUT = {
  'app.css':      'assets/app.[hash].css',
  'survey.css':   'assets/survey.[hash].css',     // ← đã có
  'home.css':     'assets/home.[hash].css',        // ← thêm khi build trang chủ portal
  'blog.css':     'assets/blog.[hash].css',        // ← thêm khi build blog
};

// laravel({ input: [...] }) — thêm entry point
input: [
  'resources/css/app.css',
  'resources/js/app.js',
  'resources/css/survey.css',                      // ← đã có
  'resources/css/home.css',                        // ← thêm khi build trang chủ portal
  'resources/css/blog.css',                        // ← thêm khi build blog
  'resources/js/modules/ai-readiness.js',
  'resources/js/modules/home.js',                  // ← thêm khi build trang chủ portal
  'resources/js/modules/blog.js',                  // ← thêm khi build blog
  'resources/js/modules/toastify.js',
  // swiper, tom-select, qrcode — giữ nguyên
],
```

> Chỉ thêm entry khi file thực sự tồn tại và trang đó cần — không khai báo trước.

---

## 4. Mục tiêu portal

1. **Tách biệt hoàn toàn** survey ↔ portal — hai sản phẩm độc lập, không chia sẻ layout, Alpine component hay asset.
2. **Cổng thông tin** phục vụ: Trang chủ marketing, Blog (listing + detail), Liên hệ, landing page tính năng.
3. **Dữ liệu động** từ CRM qua BFF — menu, bài viết, cấu hình trang đều do CRM cung cấp.
4. **SEO-first** — server-side render, mỗi page có title/meta/OG riêng, nội dung chính không phụ thuộc JS.
5. **Per-page asset** — mỗi trang chỉ tải đúng CSS + JS của mình, không rò rỉ sang trang khác.

---

## 5. Module mới: `Portal`

Tách ra khỏi `Core` và `Theme`. Cấu trúc theo AVSA:

```
Modules/Portal/
├── app/
│   ├── Actions/
│   │   └── SubmitContactAction.php
│   ├── Bff/Aggregators/
│   │   ├── HomeAggregator.php           # hero + features + CTA — Http::pool()
│   │   ├── BlogListAggregator.php       # danh sách bài + phân trang
│   │   ├── BlogDetailAggregator.php     # nội dung bài + related
│   │   └── ContactAggregator.php        # form config
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── BlogController.php
│   │   └── ContactController.php
│   └── Providers/PortalServiceProvider.php
├── resources/views/
│   ├── home.blade.php
│   ├── blog/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── contact.blade.php
│   └── partials/
│       ├── hero.blade.php
│       ├── post-card.blade.php
│       └── feature-grid.blade.php
└── routes/web.php
```

**Rule:** Controller chỉ gọi Aggregator → truyền data vào view. Không có logic trong controller.

---

## 6. Layout và theme

Portal dùng layout **`app`** (navbar + container + footer từ `theme::layouts.app`).
Survey tiếp tục dùng layout **`blank`** (tự quản lý shell).

| Trang | Layout | Theme | CSS riêng | JS riêng |
|-------|--------|-------|-----------|---------|
| Portal home | `app` | `brand-light` | `home.css` nếu có hero animation | `home.js` nếu có carousel |
| Blog listing | `app` | `brand-light` | `blog.css` nếu cần | `blog.js` nếu có swiper |
| Blog detail | `app` | `brand-light` | cùng `blog.css` | cùng `blog.js` |
| Contact | `app` | `brand-light` | không cần | `toastify.js` |
| Landing tính năng | `landing` | `brand-light` | `landing.css` nếu cần | `landing.js` nếu cần |
| Survey | `blank` | `thuchoc` | `survey.css` ✓ | `ai-readiness.js` ✓ |

> Theme override per-route qua middleware `theme:<name>`. Không hardcode trong blade.
> Nếu trang chỉ dùng DaisyUI thuần — cột "CSS riêng" và "JS riêng" để trống, không tạo file.

---

## 7. Routing

```
Portal routes (Modules/Portal/routes/web.php):

GET  /                          HomeController          → HomeAggregator
GET  /blog                      BlogController@index    → BlogListAggregator
GET  /blog/{slug}               BlogController@show     → BlogDetailAggregator
GET  /contact                   ContactController@show  → ContactAggregator
POST /contact                   ContactController@store → SubmitContactAction

Survey routes (routes/web.php — giữ nguyên):
GET  /ai-readiness              → ai-readiness.blade.php (blank + thuchoc)
POST /survey/{slug}/submit      → proxy CRM
GET  /survey/{slug}/result      → proxy CRM
```

**Navigation menu** lấy từ CRM qua `PageDataAggregator`.
`config/theme.php → nav` chỉ là fallback khi CRM không phản hồi.

---

## 8. Bundle size thực tế (baseline sau khi tách survey)

| Asset | Size | Gzip | Load trên |
|-------|------|------|-----------|
| `app.css` | 161 kB | 28 kB | Mọi trang |
| `app.js` | 0.73 kB | 0.44 kB | Mọi trang |
| `vendor-alpine.js` | 45 kB | 16 kB | Mọi trang |
| `survey.css` | 6.3 kB | 1.76 kB | `/ai-readiness` |
| `ai-readiness.js` | 15.9 kB | 5.9 kB | `/ai-readiness` |
| `vendor-toastify.js` | 6.4 kB | 2 kB | Trang có form |
| `vendor-echarts.js` | 471 kB | 159 kB | `/ai-readiness` (lazy) |

Trang blog hoặc contact tải tổng **< 45 kB gzip** (app.css + app.js + alpine) — không có byte nào từ survey hay echarts.

---

## 9. BFF Aggregator — pattern chuẩn

```php
class BlogListAggregator extends BaseAggregator
{
    public function get(int $page = 1, ?string $category = null): array
    {
        $key = "portal.blog.list.p{$page}.cat{$category}";
        return $this->remember($key, 15, function () use ($page, $category) {
            return $this->client->get('api/v1/posts', compact('page', 'category'))->data;
        });
    }
}
```

- Cache TTL: home 10 phút, blog listing 15 phút, blog detail 30 phút.
- `Http::pool()` khi home cần gọi song song: menu + hero + features.
- Mọi slug/param từ URL → `sanitizeSlug()` / `sanitizeId()` trước khi vào API URL.

---

## 10. SEO per-page

```blade
{{-- blog/show.blade.php --}}
@section('title', $post['title'] . ' — ' . config('app.name'))
@section('meta_description', $post['excerpt'])
@section('og_meta')
    <meta property="og:type"  content="article">
    <meta property="og:image" content="{{ $post['cover_url'] }}">
@endsection
```

`base/document.blade.php` cần khai báo thêm `@yield('og_meta')` trong `<head>` để các trang con override được.

---

## 11. Khác biệt then chốt: Portal vs Survey

| Tiêu chí | Survey | Portal |
|----------|--------|--------|
| Layout | `blank` — self-contained | `app` / `landing` — navbar/footer chung |
| Data flow | JSON inject qua `data-schema` | Server-side render từ Aggregator → Blade |
| JS | Alpine heavy (multi-step, polling, ECharts) | Alpine light (toggle, theme switcher) |
| CSS | `survey.css` — load riêng | `<page>.css` — load riêng từng trang |
| Asset strategy | Per-page ✓ | Per-page ✓ (cùng nguyên tắc) |
| Routing | `routes/web.php` | `Modules/Portal/routes/web.php` |
| Cache | Schema 10 phút | Blog detail 30 phút, listing 15 phút |
| Nav | Trong blade survey (không cần) | Từ CRM qua `PageDataAggregator` |

---

## 12. Thứ tự build đề xuất

1. `Modules/Portal` skeleton — ServiceProvider, routes, base controller
2. `HomeController` + `HomeAggregator` + `home.blade.php`
   - Tạo `resources/css/home.css` và `resources/js/modules/home.js` **nếu** cần animation/carousel
3. `BlogController` + `BlogListAggregator` + `blog/index.blade.php`
   - Tạo `resources/css/blog.css` và `resources/js/modules/blog.js` **nếu** cần style bài viết
4. `BlogController@show` + `BlogDetailAggregator` + `blog/show.blade.php`
5. `ContactController` + `SubmitContactAction` + `contact.blade.php`
   - Load `toastify.js` qua `head_extra` — không cần CSS riêng
6. Dynamic menu từ CRM — `PageDataAggregator` → pass `$menu` vào navbar partial
7. Landing pages tính năng — layout `landing`, tái dùng partials

> Mỗi bước là một PR độc lập.
> Chỉ tạo `<page>.css` / `<page>.js` khi trang đó thực sự cần — nếu DaisyUI đủ thì không tạo.
