{{-- Alpine scope chỉ bao header + mobile drawer — không ảnh hưởng đến các section bên dưới --}}
<div x-data="{ scrolled: false, menuOpen: false }" @scroll.window="scrolled = window.scrollY > 12">

<!-- ============ HEADER ============ -->
<header class="sticky top-0 z-[100] backdrop-blur-md transition-all duration-300 border-b"
        :class="scrolled ? 'bg-base-100/90 border-base-300 shadow-sm' : 'bg-base-100/80 border-transparent'">
  <div class="max-w-[1200px] mx-auto px-7">
    <nav class="flex items-center gap-9 transition-all duration-300" :class="scrolled ? 'h-[68px]' : 'h-20'">
      <a href="{{ url('/') }}" class="shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="THUCHOCVN" class="w-auto transition-all duration-300" :class="scrolled ? 'h-9' : 'h-[42px]'" />
      </a>

      <div class="hidden lg:flex items-center gap-1 ml-1">
        <a href="{{ url('/') }}" class="px-3.5 py-2 rounded-lg text-[.96rem] font-semibold text-primary">Trang chủ</a>
        <a href="#" class="px-3.5 py-2 rounded-lg text-[.96rem] font-medium text-secondary/90 hover:text-primary hover:bg-base-200 transition-colors">Giới thiệu</a>
        {{-- Dropdown Giải pháp: Alpine mouseenter/leave trên wrapper bao cả trigger + panel
             → chuột di chuyển qua vùng pt-2 (bridge trong suốt) vẫn giữ open=true --}}
        <div class="relative"
             x-data="{ open: false }"
             @mouseenter="open = true"
             @mouseleave="open = false"
             @keydown.escape.window="open = false">

          <button type="button"
                  class="px-3.5 py-2 rounded-lg text-[.96rem] font-medium text-secondary/90 hover:text-primary hover:bg-base-200 transition-colors flex items-center gap-1.5"
                  :class="open ? 'text-primary bg-base-200' : ''"
                  @click="open = !open"
                  :aria-expanded="open">
            Giải pháp
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                 class="transition-transform duration-200" :class="open ? 'rotate-180' : ''">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </button>

          {{-- pt-2 tạo bridge trong suốt — chuột di từ trigger xuống panel không rơi vào dead zone --}}
          <div x-show="open"
               x-transition:enter="transition ease-out duration-150"
               x-transition:enter-start="opacity-0 -translate-y-1"
               x-transition:enter-end="opacity-100 translate-y-0"
               x-transition:leave="transition ease-in duration-100"
               x-transition:leave-start="opacity-100 translate-y-0"
               x-transition:leave-end="opacity-0 -translate-y-1"
               class="absolute top-full left-0 pt-2 w-[330px] z-[120]">
            <ul class="bg-base-100 rounded-box shadow-xl border border-base-300 p-2">
              <li><a href="#ai-ceo" class="flex gap-3 py-2.5 px-3 rounded-xl hover:bg-base-200 transition-colors"><span class="w-9 h-9 rounded-[10px] grid place-items-center bg-secondary text-secondary-content shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="11" width="3" height="6" rx="1"/><rect x="12" y="7" width="3" height="10" rx="1"/><rect x="17" y="13" width="3" height="4" rx="1"/></svg></span><span><span class="block font-bold text-secondary text-[.95rem] leading-tight">AI For CEO</span><span class="block text-xs text-base-content/60">Quản trị &amp; điều hành thông minh</span></span></a></li>
              <li><a href="#ai-sales" class="flex gap-3 py-2.5 px-3 rounded-xl hover:bg-base-200 transition-colors"><span class="w-9 h-9 rounded-[10px] grid place-items-center bg-secondary text-secondary-content shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg></span><span><span class="block font-bold text-secondary text-[.95rem] leading-tight">AI For Sales</span><span class="block text-xs text-base-content/60">Tăng trưởng &amp; chuyển đổi bán hàng</span></span></a></li>
              <li><a href="#ai-training" class="flex gap-3 py-2.5 px-3 rounded-xl hover:bg-base-200 transition-colors"><span class="w-9 h-9 rounded-[10px] grid place-items-center bg-secondary text-secondary-content shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span><span><span class="block font-bold text-secondary text-[.95rem] leading-tight">AI Training</span><span class="block text-xs text-base-content/60">Đào tạo AI thực chiến</span></span></a></li>
              <li><a href="#workforce" class="flex gap-3 py-2.5 px-3 rounded-xl hover:bg-base-200 transition-colors"><span class="w-9 h-9 rounded-[10px] grid place-items-center bg-secondary text-secondary-content shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg></span><span><span class="block font-bold text-secondary text-[.95rem] leading-tight">Workforce Development</span><span class="block text-xs text-base-content/60">Phát triển nhân lực thực chiến</span></span></a></li>
            </ul>
          </div>
        </div>
        <a href="#" class="px-3.5 py-2 rounded-lg text-[.96rem] font-medium text-secondary/90 hover:text-primary hover:bg-base-200 transition-colors">Nền tảng số</a>
        <a href="{{ url('/contact') }}" class="px-3.5 py-2 rounded-lg text-[.96rem] font-medium text-secondary/90 hover:text-primary hover:bg-base-200 transition-colors">Liên hệ</a>
      </div>

      <div class="ml-auto flex items-center gap-4">
        <span class="hidden md:flex items-center gap-2 font-bold text-secondary text-[.95rem]">
          <svg class="text-primary" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          0397 791 737
        </span>
        <a href="{{ url('/contact') }}" class="btn btn-primary rounded-full hidden sm:inline-flex">Tư vấn miễn phí</a>
        <button class="btn btn-ghost btn-square lg:hidden" @click="menuOpen = true" aria-label="Menu">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
      </div>
    </nav>
  </div>
</header>

<!-- ============ MOBILE DRAWER ============ -->
<div x-cloak x-show="menuOpen" x-transition.opacity @click="menuOpen = false" class="fixed inset-0 bg-black/45 z-[200]"></div>
<aside x-cloak x-show="menuOpen"
       x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
       class="fixed top-0 right-0 h-full w-[min(360px,86vw)] bg-base-100 z-[210] p-6 overflow-y-auto flex flex-col gap-1.5">
  <div class="flex justify-between items-center mb-3">
    <img src="{{ asset('images/logo.png') }}" alt="THUCHOCVN" class="h-9" />
    <button class="btn btn-ghost btn-square" @click="menuOpen = false" aria-label="Đóng">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <a href="{{ url('/') }}" @click="menuOpen = false" class="py-3.5 px-3 rounded-xl font-semibold text-secondary text-lg border-b border-base-200">Trang chủ</a>
  <a href="#" @click="menuOpen = false" class="py-3.5 px-3 rounded-xl font-semibold text-secondary text-lg border-b border-base-200">Giới thiệu</a>
  <a href="#giai-phap" @click="menuOpen = false" class="py-3.5 px-3 rounded-xl font-semibold text-secondary text-lg border-b border-base-200">Giải pháp</a>
  <a href="#ai-ceo" @click="menuOpen = false" class="py-2.5 pl-6 rounded-xl font-medium text-base-content/60">AI For CEO</a>
  <a href="#ai-sales" @click="menuOpen = false" class="py-2.5 pl-6 rounded-xl font-medium text-base-content/60">AI For Sales</a>
  <a href="#ai-training" @click="menuOpen = false" class="py-2.5 pl-6 rounded-xl font-medium text-base-content/60">AI Training</a>
  <a href="#workforce" @click="menuOpen = false" class="py-2.5 pl-6 rounded-xl font-medium text-base-content/60">Workforce Development</a>
  <a href="#" @click="menuOpen = false" class="py-3.5 px-3 rounded-xl font-semibold text-secondary text-lg border-b border-base-200">Nền tảng số</a>
  <a href="{{ url('/contact') }}" @click="menuOpen = false" class="py-3.5 px-3 rounded-xl font-semibold text-secondary text-lg border-b border-base-200">Liên hệ</a>
  <a href="{{ url('/contact') }}" @click="menuOpen = false" class="btn btn-primary rounded-full mt-4">Tư vấn miễn phí</a>
</aside>

</div>{{-- end x-data nav scope --}}
