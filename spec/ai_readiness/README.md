# THUCHOCVN · AI Readiness — bộ Laravel 13 + Vite

Bộ file đã tách sẵn từ bản HTML hi-fi đã duyệt, dùng **Alpine.js 3 + DaisyUI 5 + Tailwind CSS 4** qua Vite (không còn CDN).

## Cấu trúc

```
resources/
  css/app.css                 # Tailwind + DaisyUI + theme "thuchoc" (màu thương hiệu) + component CSS
  js/app.js                   # entry: nạp Alpine, đăng ký surveyApp, Alpine.start()
  js/survey/data.js           # 9 phần câu hỏi + thang điểm (ES module)
  js/survey/app.js            # logic Alpine: điều hướng, chấm điểm, live-score, radar, báo cáo
  views/ai-readiness.blade.php# giao diện (đã chuyển @click → x-on:click cho khỏi đụng Blade)
package.json                  # dependencies
vite.config.js                # Vite + laravel-vite-plugin + @tailwindcss/vite
routes/web.php                # route GET trang + POST nhận dữ liệu (tuỳ chọn)
```

## Cài vào dự án Laravel 13

1. **Chép file** vào đúng vị trí trong dự án (gộp `resources/`, `routes/web.php`, `vite.config.js`; merge `package.json`).

2. **Cài dependencies**
   ```bash
   npm install alpinejs chart.js
   npm install -D tailwindcss @tailwindcss/vite laravel-vite-plugin vite
   ```

3. **Chạy dev**
   ```bash
   npm run dev          # terminal 1 (Vite)
   php artisan serve    # terminal 2
   ```
   Mở `http://localhost:8000/ai-readiness`.

4. **Build production**
   ```bash
   npm run build
   ```

## Ghi chú kỹ thuật

- **Theme màu** định nghĩa trong `app.css` ở block `@plugin "daisyui/theme" { name:"thuchoc"; default:true; ... }`. Đổi màu thương hiệu tại đây. View đặt `data-theme="thuchoc"` trên thẻ `<html>`.
- **Blade vs Alpine:** đã đổi toàn bộ `@click`/`@submit.prevent` sang `x-on:click`/`x-on:submit.prevent` để Blade không hiểu nhầm `@` là directive. View không dùng `{{ }}` của Alpine, nên an toàn. Nếu sau này thêm cú pháp dễ đụng, bọc khối đó trong `@verbatim ... @endverbatim`.
- **Font** Be Vietnam Pro + Space Grotesk đang nạp qua Google Fonts trong `<head>`. Có thể tự host nếu muốn.
- **localStorage:** form tự lưu nháp (key `thuchoc_air_v2`) và khôi phục khi quay lại — thuần client, không cần backend.

## Lưu kết quả về server (tuỳ chọn)

Đã có sẵn route `POST /api/ai-readiness` trong `routes/web.php`. Để gửi dữ liệu, thêm vào cuối hàm `submit()` trong `resources/js/survey/app.js`:

```js
submit() {
  this.submitted = true;
  fetch('/api/ai-readiness', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({
      answers: this.answers,
      scores: this.scores,
      overall: this.overall,
      level: this.level.name,
    }),
  });
  this.$nextTick(() => { this.renderRadar(); /* ...scroll... */ });
}
```

(Thẻ `<meta name="csrf-token">` đã có sẵn trong `<head>` của view.)
