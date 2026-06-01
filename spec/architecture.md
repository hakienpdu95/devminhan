# Project Frontend Architecture

## 1. Tổng quan dự án

- **Project**: Frontend website
- **Mục tiêu**: Xây dựng cổng thông tin công khai với nội dung động (blog, sản phẩm, menu, page tùy biến…).
- **Kiến trúc tổng thể**: **Advanced Vertical Slice Architecture (AVSA) + CQRS-lite + Laravel Modules + Laravel Actions + BFF Pattern**.
- **Giao tiếp với CRM**: Chỉ consume **REST API** từ project CRM qua **Laravel Sanctum API Token**.
- **Không** share database, không dùng GraphQL.

**Mục tiêu chính**:
- Hiệu suất cao nhất có thể (cache mạnh, ít request ra CRM).
- Bảo mật cấp cao nhất.
- Linh hoạt theme/template cho từng page.
- Code rõ ràng, dễ maintain, dễ scale.

## 2. Kiến trúc & Nguyên tắc thiết kế

### Kiến trúc chính
- **Advanced Vertical Slice Architecture (AVSA)**: Code được tổ chức theo **feature/business slice** thay vì theo layer.
- **CQRS-lite**: Tách rõ **Query** (đọc data) và **Command** (ghi data). Frontend chủ yếu dùng Query.
- **Laravel Modules** (`nwidart/laravel-modules`): Mỗi feature là một module độc lập.
- **Laravel Actions** (`lorisleiva/laravel-actions`): Mọi business logic được đóng gói thành Action.
- **BFF Pattern (Backend-for-Frontend)**: Layer trung gian trong `Core` module để aggregate nhiều REST API calls từ CRM thành 1-2 request.
- **Cache-first**: Toàn bộ data động được cache mạnh ở nhiều tầng.

### Nguyên tắc thiết kế (phải tuân thủ nghiêm ngặt)
1. Controller chỉ dispatch Query/Aggregator → không chứa logic.
2. Mọi logic gọi API CRM phải đi qua `Bff/Aggregators` hoặc `Api/SanctumApiClient`.
3. Cache phải dùng `Cache::tags()` để dễ invalidate.
4. Theme/view phải linh hoạt theo page (per-page theme).
5. Security logic tập trung ở `Core/Security`.
6. Mọi response từ CRM phải được chuẩn hóa qua DTO (`ApiResponse`).

## 3. Yêu cầu chức năng chính (Frontend)

- Trang chủ, blog list/detail, sản phẩm list/detail, menu động.
- Hỗ trợ nhiều theme/template (default, modern, luxury, custom…) có thể extend từ template các master khác nhau
- Page tùy biến (landing page, campaign…).
- Tối ưu SEO (meta tags động).
- Hiệu suất cao (TTFB thấp, caching mạnh).

## 4. Bảo mật (Security - Cấp cao nhất)

- Sử dụng **Sanctum API Token** từ CRM (token rotation khuyến khích).
- Rate limiting mạnh (per IP + per user).
- CSP, Secure Headers, X-Frame-Options, Referrer-Policy.
- Input validation + sanitization nghiêm ngặt ở mọi Aggregator.
- Logging request/response (không log sensitive data).
- Middleware kiểm tra token validity trước khi gọi API.
- Không lưu token ở client-side (sử dụng session hoặc cookie httpOnly nếu cần).

## 5. Hiệu suất (Performance - Cao nhất)

- Redis cache + Cache Tags.
- HTTP Pool (`Http::pool()`) trong BFF Aggregator.
- Aggressive caching ở Aggregator → Query → HTTP layer.
- View caching + Blade component cache.
- CDN cho static assets.

## 6. Cấu trúc thư mục chi tiết (phải tuân thủ)

devminhan/
├── Modules/
│   ├── Core/                          # BFF + Security + Cache + Api Client
│   │   ├── Bff/Aggregators/
│   │   ├── Api/SanctumApiClient.php
│   │   ├── Security/
│   │   ├── Caching/
│   │   ├── Queries/
│   │   ├── Actions/
│   │   └── Providers/
│   ├── Blog/
│   ├── Page/
│   ├── Theme/                         # Theme + layout system (DaisyUI-native)
│   │   ├── app/
│   │   │   ├── Actions/ResolveThemeAction.php
│   │   │   └── Http/Middleware/ResolveThemeMiddleware.php
│   │   └── resources/views/
│   │       ├── base/document.blade.php     # <html data-theme>, SEO, @vite
│   │       ├── layouts/                     # app | landing | minimal (extend base)
│   │       ├── partials/                    # navbar, footer, theme-switcher
│   │       └── overrides/
│   └── ...
├── app/
│   ├── Http/Controllers/              # Controller mỏng
│   ├── Providers/RouteServiceProvider.php
│   └── Exceptions/
├── config/
│   ├── bff.php
│   ├── sanctum.php
│   ├── security.php
│   ├── theme.php
│   └── cache.php
├── routes/web.php
└── .env


## 7. Công nghệ & Package đã cài

**Backend / kiến trúc**
- `nwidart/laravel-modules`
- `lorisleiva/laravel-actions`
- Redis
- Laravel Sanctum (client side)

**Frontend / UI (trọng tâm giao diện)**
- **DaisyUI 5** — nguồn token màu/shape duy nhất qua thuộc tính `data-theme`.
  Không tự xây hệ SCSS token. Hai theme thương hiệu custom (`brand-light`, `brand-dark`)
  + nhiều theme built-in, gói chung 1 file CSS, đổi theme = đổi 1 thuộc tính.
- **Alpine.js 3** — tương tác client (theme switcher, survey form đa bước…).
- **Tailwind CSS v4** — utility + `@plugin "daisyui"` (vite-native, không cần `tailwind.config.js`).
- Build bằng `vite.config.frontend.js` → `public/build/frontend`
  (Laravel trỏ qua `Vite::useBuildDirectory('build/frontend')`).
- Module JS tải lazy theo trang: `swiper`, `tom-select`, `toastify`, `qrcode`.

### Nguyên tắc UI/UX
- **Theme (màu) ⟂ Layout (cấu trúc)** — hai trục độc lập, phối tự do.
  Theme = `data-theme`; Layout = master Blade kế thừa từ `theme::base.document`.
- Component dùng class DaisyUI (`navbar`, `card`, `btn`, `input`…) + utility ngữ nghĩa
  (`bg-base-100`, `text-base-content`, `btn-primary`) — **không hardcode màu**, để mọi
  theme tự áp dụng.
- Layout mới = thêm 1 file trong `layouts/` + đăng ký `config/theme.php`.
  Theme mới = khai báo trong `app.css` + đăng ký `config/theme.php`.

## 8. Hướng dẫn thực thi (dành cho Claude / Developer)

1. Kiểm tra và Cài các package cần thiết.
2. Tạo các module: `Core`, `Theme`, `Page` bằng lệnh, hãy hỏi khi áp dụng
3. Implement `SanctumApiClient` và `Bff/Aggregators`.
4. Xây dựng Theme system (ThemeResolver + dynamic view path).
5. Implement caching strategy.
6. Viết middleware bảo mật.
7. Test performance và bảo mật.

**Bạn hãy bắt đầu bằng cách**:
- Implement từng module theo thứ tự: Core → Theme → Blog.