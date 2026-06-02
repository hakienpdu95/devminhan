<!-- ============ FOOTER ============ -->
<footer class="relative overflow-hidden text-white pt-19 pb-8 bg-[#191f33]">
  <div class="absolute top-0 inset-x-0 h-[3px] bg-[linear-gradient(90deg,#f07a22_0%,#f07a22_45%,#15a088_100%)]"></div>
  <div class="absolute -right-50 -top-30 w-[480px] h-[480px] rounded-full bg-[radial-gradient(circle,rgba(240,122,34,.10),transparent_64%)] pointer-events-none"></div>
  <div class="max-w-[1200px] mx-auto px-7 relative z-10">
    <!-- newsletter -->
    <div class="flex justify-between items-center gap-x-12 gap-y-7 flex-wrap pb-10 mb-11 border-b border-white/12">
      <div class="max-w-[520px]">
        <span class="inline-flex items-center gap-2 text-[.74rem] font-bold tracking-[.12em] uppercase text-[#FFB87A] mb-3">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          Bản tin AI For Work
        </span>
        <h3 class="text-white text-[1.5rem] font-extrabold mb-2 tracking-[-.01em]">Cập nhật cách ứng dụng AI vào công việc</h3>
        <p class="text-white/60 text-[.97rem]">Nhận các góc nhìn về AI For Work, workflow tự động hóa và phát triển nguồn nhân lực thực chiến — gửi tới hộp thư của bạn.</p>
      </div>
      <div x-data="{ sent: false }">
        <form x-show="!sent" class="join w-full sm:w-auto" @submit.prevent="sent = true">
          <input type="email" placeholder="Nhập email của bạn" aria-label="Email" required
                 class="input join-item bg-white/8 border-white/16 text-white placeholder:text-white/45 w-full sm:w-72 focus:border-primary" />
          <button type="submit" class="btn btn-primary join-item rounded-r-full">Đăng ký</button>
        </form>
        <p x-show="sent" x-cloak class="flex items-center gap-2.5 text-white/80 font-medium py-3">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><polyline points="20 6 9 17 4 12"/></svg>
          Cảm ơn! Chúng tôi sẽ gửi bản tin đến hộp thư của bạn.
        </p>
      </div>
    </div>
    <!-- columns -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[1.7fr_1fr_1fr_1.2fr] gap-x-11 gap-y-9">
      <div>
        <img src="{{ asset('images/logo.png') }}" alt="THUCHOCVN" class="h-[46px] w-auto mb-4.5 brightness-0 invert" />
        <p class="text-white/60 text-[.95rem] max-w-[330px] text-pretty">AI For Work &amp; Workforce Development. Đồng hành cùng doanh nghiệp và người Việt trong thời đại AI — học thật, làm thật, tạo giá trị thật.</p>
        <div class="flex flex-wrap gap-2 mt-5">
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">AI For Work</span>
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">AI Training</span>
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">AI For CEO</span>
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">AI For Sales</span>
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">Workflow Automation</span>
          <span class="text-[.78rem] font-semibold text-white/72 bg-white/6 border border-white/12 rounded-full px-3 py-1">Workforce Development</span>
        </div>
      </div>
      <div>
        <h4 class="text-[.8rem] tracking-[.12em] uppercase text-white/45 mb-4.5 font-bold">Giải pháp</h4>
        <ul class="flex flex-col gap-3 text-[.94rem] text-white/78">
          <li><a href="#ai-ceo" class="hover:text-primary transition-colors">AI For CEO</a></li>
          <li><a href="#ai-sales" class="hover:text-primary transition-colors">AI For Sales</a></li>
          <li><a href="#ai-training" class="hover:text-primary transition-colors">AI Training</a></li>
          <li><a href="#workforce" class="hover:text-primary transition-colors">Workforce Development</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-[.8rem] tracking-[.12em] uppercase text-white/45 mb-4.5 font-bold">Khám phá</h4>
        <ul class="flex flex-col gap-3 text-[.94rem] text-white/78">
          <li><a href="#" class="hover:text-primary transition-colors">Giới thiệu</a></li>
          <li><a href="#" class="hover:text-primary transition-colors">Nền tảng số</a></li>
          <li><a href="#triet-ly" class="hover:text-primary transition-colors">Triết lý phát triển</a></li>
          <li><a href="#giai-phap" class="hover:text-primary transition-colors">Hệ sinh thái giải pháp</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-[.8rem] tracking-[.12em] uppercase text-white/45 mb-4.5 font-bold">Liên hệ</h4>
        <ul class="flex flex-col gap-3 text-[.94rem] text-white/78">
          <li class="flex items-center gap-2.5">
            <svg class="text-primary shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            0397 791 737
          </li>
          <li class="flex items-center gap-2.5">
            <svg class="text-primary shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            admin@thuchocvn.vn
          </li>
          <li class="flex items-center gap-2.5">
            <svg class="text-primary shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            thuchocvn.vn
          </li>
          <li class="flex items-center gap-2.5">
            <svg class="text-primary shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Hà Nội, Việt Nam
          </li>
        </ul>
        <div class="flex gap-2.5 mt-4">
          <a href="#" aria-label="Facebook" class="w-9.5 h-9.5 rounded-[10px] grid place-items-center bg-white/8 text-white hover:bg-primary hover:-translate-y-0.5 transition-all"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z"/></svg></a>
          <a href="#" aria-label="LinkedIn" class="w-9.5 h-9.5 rounded-[10px] grid place-items-center bg-white/8 text-white hover:bg-primary hover:-translate-y-0.5 transition-all"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM10 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.6c0-1.34-.02-3.06-1.86-3.06-1.86 0-2.15 1.46-2.15 2.96V21h-4z"/></svg></a>
          <a href="#" aria-label="YouTube" class="w-9.5 h-9.5 rounded-[10px] grid place-items-center bg-white/8 text-white hover:bg-primary hover:-translate-y-0.5 transition-all"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.2-.4-4.7a2.5 2.5 0 0 0-1.7-1.8C19.4 5 12 5 12 5s-7.4 0-8.9.5A2.5 2.5 0 0 0 1.4 7.3C1 8.8 1 12 1 12s0 3.2.4 4.7a2.5 2.5 0 0 0 1.7 1.8C4.6 19 12 19 12 19s7.4 0 8.9-.5a2.5 2.5 0 0 0 1.7-1.8C23 15.2 23 12 23 12zM10 15V9l5 3z"/></svg></a>
        </div>
      </div>
    </div>
    <!-- bottom -->
    <div class="flex justify-between items-center gap-4 flex-wrap mt-12 pt-6 border-t border-white/12 text-[.85rem]">
      <p class="text-white/55">&copy; {{ date('Y') }} <b class="text-white/85 font-bold">Công ty TNHH Phát triển Nhân lực Thực học Việt Nam</b>. Doanh nghiệp xã hội.</p>
      <div class="flex items-center gap-x-5.5 gap-y-2 flex-wrap">
        <a href="#" class="text-white/50 hover:text-primary transition-colors">Chính sách bảo mật</a>
        <span class="text-white/25">·</span>
        <a href="#" class="text-white/50 hover:text-primary transition-colors">Điều khoản sử dụng</a>
        <a href="#top" class="inline-flex items-center gap-2 text-white/60 hover:text-white font-semibold transition-colors">Lên đầu trang <span class="w-8.5 h-8.5 rounded-[10px] bg-white/8 grid place-items-center hover:bg-primary transition-colors"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg></span></a>
      </div>
    </div>
  </div>
</footer>
