@extends($themeMaster)

@section('title', 'THUCHOCVN — Học thật · Làm thật · Giá trị thật')
@section('meta_description', 'THUCHOCVN — AI For Work & Workforce Development. Kiến tạo hệ sinh thái phát triển nguồn nhân lực thực chiến và ứng dụng AI trong công việc tại Việt Nam.')

@section('head_extra')
    @vite(['resources/css/home.css', 'resources/js/modules/home.js'])
@endsection

@section('content')
<div id="top">

    @include('portal::partials.header')

    {{-- ============ HERO ============ --}}
    <section class="hero-bg relative overflow-hidden">
      <div class="dotgrid absolute inset-0 z-0"></div>
      <svg class="absolute top-[60px] left-[46%] w-[130px] text-[rgba(46,58,94,.05)] spin-slow z-0" viewBox="0 0 100 100" fill="currentColor"><path d="M50 0l6 12 13-4 2 14 14 2-4 13 12 6-12 6 4 13-14 2-2 14-13-4-6 12-6-12-13 4-2-14-14-2 4-13L0 50l12-6-4-13 14-2 2-14 13 4z"/><circle cx="50" cy="50" r="18" fill="#fff"/></svg>
      <svg class="absolute -bottom-2.5 right-[4%] w-[230px] text-[rgba(46,58,94,.05)] spin-slow-rev z-0" viewBox="0 0 100 100" fill="currentColor"><path d="M50 0l6 12 13-4 2 14 14 2-4 13 12 6-12 6 4 13-14 2-2 14-13-4-6 12-6-12-13 4-2-14-14-2 4-13L0 50l12-6-4-13 14-2 2-14 13 4z"/><circle cx="50" cy="50" r="18" fill="#fff"/></svg>

      <div class="max-w-[1200px] mx-auto px-7 relative z-10">
        <div class="grid lg:grid-cols-[1.05fr_.95fr] gap-14 items-center pt-[72px]">
          <!-- copy -->
          <div class="reveal in">
            <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary">
              <span class="w-7 h-0.5 bg-primary rounded"></span>AI For Work · Workforce Development
            </span>
            <h1 class="font-extrabold leading-[1.03] tracking-[-.025em] text-secondary mt-4 text-[clamp(2.7rem,5.6vw,4.5rem)]">
              Học <span class="uline">thật</span>.<br />Làm <span class="uline">thật</span>.<br />Giá trị <span class="uline">thật</span>.
            </h1>
            <p class="text-[1.16rem] text-base-content/60 mt-6 mb-8 max-w-[520px] text-pretty">
              THUCHOCVN kiến tạo hệ sinh thái phát triển nguồn nhân lực <b class="text-secondary font-bold">thực chiến</b> và ứng dụng AI vào công việc thực tế — đồng hành cùng doanh nghiệp và người Việt trong thời đại mới.
            </p>
            <div class="flex gap-3.5 flex-wrap">
              <a href="#giai-phap" class="btn btn-primary rounded-full">Khám phá giải pháp
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="#" class="btn btn-outline border-base-300 text-secondary hover:bg-secondary hover:border-secondary hover:text-secondary-content rounded-full">Về THUCHOCVN</a>
            </div>
            <div class="flex items-center gap-x-[18px] gap-y-2 flex-wrap mt-9 text-[.9rem] text-base-content/60 font-medium">
              <span>Đồng hành cùng</span>
              <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><b class="text-secondary font-bold">Doanh nghiệp</b></span>
              <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><b class="text-secondary font-bold">Người học</b></span>
              <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><b class="text-secondary font-bold">Nhà trường</b></span>
              <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><b class="text-secondary font-bold">Nhà nước</b></span>
            </div>
          </div>

          <!-- visual: AI For Work dashboard -->
          <div class="relative reveal in d2">
            <div class="absolute inset-x-[-30px] top-6 -bottom-8 rounded-[28px] bg-[linear-gradient(150deg,rgba(240,122,34,.14),rgba(21,160,136,.12))] blur-[2px] z-0"></div>
            <div class="relative z-10 bg-base-100 border border-base-300 rounded-[22px] p-3 shadow-2xl">
              <div class="flex items-center gap-1.5 px-2 pt-1.5 pb-3">
                <i class="w-2.5 h-2.5 rounded-full bg-primary/80"></i><i class="w-2.5 h-2.5 rounded-full bg-base-300"></i><i class="w-2.5 h-2.5 rounded-full bg-base-300"></i>
                <span class="ml-2.5 text-[.78rem] font-bold text-base-content/50 tracking-wide">THUCHOCVN · AI For Work</span>
              </div>
              <div class="rounded-[14px] p-[15px] flex flex-col gap-3 bg-[linear-gradient(165deg,#EEF2F8_0%,#F8FAFC_60%,#fff_100%)] border border-base-300">
                <!-- head -->
                <div class="flex justify-between items-center">
                  <div><div class="font-extrabold text-secondary text-[1.05rem] leading-tight">AI For Work</div><div class="text-[.75rem] text-base-content/50 font-medium mt-0.5">Không gian làm việc thông minh</div></div>
                  <span class="inline-flex items-center gap-1.5 text-[.73rem] font-bold text-accent bg-accent/10 border border-accent/20 px-2.5 py-1.5 rounded-full"><span class="w-[7px] h-[7px] rounded-full bg-accent pulse-dot"></span>Tự động hóa đang chạy</span>
                </div>
                <!-- workflow panel -->
                <div class="bg-base-100 border border-base-300 rounded-[13px] p-3.5 shadow-sm">
                  <div class="flex justify-between items-center mb-3.5"><b class="text-[.86rem] text-secondary">Quy trình vận hành</b><span class="text-[.68rem] font-extrabold text-primary bg-primary/10 px-2.5 py-1 rounded-full">Đang tối ưu</span></div>
                  <div class="flex items-start">
                    <div class="flex-1 text-center"><span class="w-[34px] h-[34px] rounded-full mx-auto mb-2 grid place-items-center bg-accent text-accent-content"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="text-[.68rem] font-bold text-secondary">Khảo sát</span></div>
                    <div class="flex-[0_0_16px] h-0.5 bg-accent mt-4 rounded"></div>
                    <div class="flex-1 text-center"><span class="w-[34px] h-[34px] rounded-full mx-auto mb-2 grid place-items-center bg-accent text-accent-content"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="text-[.68rem] font-bold text-secondary">Phân tích</span></div>
                    <div class="flex-[0_0_16px] h-0.5 bg-base-300 mt-4 rounded"></div>
                    <div class="flex-1 text-center"><span class="w-[34px] h-[34px] rounded-full mx-auto mb-2 grid place-items-center bg-base-100 border-2 border-primary text-primary shadow-[0_0_0_4px_rgba(240,122,34,.12)]"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5 5l2 2M17 17l2 2M19 5l-2 2M7 17l-2 2"/></svg></span><span class="text-[.68rem] font-bold text-secondary">Tự động hóa</span></div>
                    <div class="flex-[0_0_16px] h-0.5 bg-base-300 mt-4 rounded"></div>
                    <div class="flex-1 text-center"><span class="w-[34px] h-[34px] rounded-full mx-auto mb-2 grid place-items-center bg-base-100 border-2 border-base-300 text-base-content/40"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></span><span class="text-[.68rem] font-bold text-base-content/40">Báo cáo</span></div>
                  </div>
                </div>
                <!-- row: trend + gauge -->
                <div class="grid grid-cols-[1.25fr_1fr] gap-2.5">
                  <div class="bg-base-100 border border-base-300 rounded-[13px] p-3.5 shadow-sm flex flex-col">
                    <div class="text-[.77rem] text-base-content/60 font-semibold mb-2.5">Hiệu suất vận hành</div>
                    <div class="flex items-end gap-[5px] h-[42px]">
                      <i class="flex-1 bg-base-300 rounded-t" style="height:34%"></i><i class="flex-1 bg-base-300 rounded-t" style="height:48%"></i><i class="flex-1 bg-base-300 rounded-t" style="height:40%"></i><i class="flex-1 bg-base-300 rounded-t" style="height:62%"></i><i class="flex-1 bg-base-300 rounded-t" style="height:78%"></i><i class="flex-1 bg-primary rounded-t" style="height:100%"></i>
                    </div>
                    <div class="flex items-center gap-1.5 mt-2.5 text-[.73rem] font-bold text-accent"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>Đang cải thiện</div>
                  </div>
                  <div class="rounded-[13px] p-3 text-white flex flex-col items-center justify-center text-center shadow-sm bg-[linear-gradient(155deg,#2e3a5e,#202942)]">
                    <div class="ring-opt w-[58px] h-[58px] rounded-full grid place-items-center mb-2.5"><div class="w-[42px] h-[42px] rounded-full grid place-items-center bg-[#202942] text-primary"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/></svg></div></div>
                    <div class="text-[.73rem] text-white/80 font-semibold leading-tight">Tối ưu<br />vận hành</div>
                  </div>
                </div>
                <!-- modules -->
                <div class="grid grid-cols-4 gap-2">
                  <div class="bg-base-100 border border-base-300 rounded-[11px] py-3 px-1 text-center"><span class="w-8 h-8 rounded-[9px] grid place-items-center mx-auto mb-1.5 bg-secondary/10 text-secondary"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="11" width="3" height="6" rx="1"/><rect x="12" y="7" width="3" height="10" rx="1"/><rect x="17" y="13" width="3" height="4" rx="1"/></svg></span><span class="text-[.63rem] font-bold text-secondary/80 leading-tight">AI CEO</span></div>
                  <div class="bg-base-100 border border-base-300 rounded-[11px] py-3 px-1 text-center"><span class="w-8 h-8 rounded-[9px] grid place-items-center mx-auto mb-1.5 bg-secondary/10 text-secondary"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg></span><span class="text-[.63rem] font-bold text-secondary/80 leading-tight">AI Sales</span></div>
                  <div class="bg-base-100 border border-base-300 rounded-[11px] py-3 px-1 text-center"><span class="w-8 h-8 rounded-[9px] grid place-items-center mx-auto mb-1.5 bg-secondary/10 text-secondary"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2.5 9 2.5 12 0v-5"/></svg></span><span class="text-[.63rem] font-bold text-secondary/80 leading-tight">Training</span></div>
                  <div class="bg-base-100 border border-base-300 rounded-[11px] py-3 px-1 text-center"><span class="w-8 h-8 rounded-[9px] grid place-items-center mx-auto mb-1.5 bg-secondary/10 text-secondary"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg></span><span class="text-[.63rem] font-bold text-secondary/80 leading-tight">Workforce</span></div>
                </div>
              </div>
            </div>
            <!-- floating cards -->
            <div class="floaty absolute -top-6 -left-7 bg-base-100 border border-base-300 rounded-2xl shadow-xl py-3.5 px-[17px] items-center gap-3.5 hidden sm:flex">
              <span class="w-[42px] h-[42px] rounded-[11px] grid place-items-center bg-primary/10 text-primary"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></span>
              <div><div class="text-[.76rem] text-base-content/50 font-medium">Đào tạo AI</div><div class="text-[1.02rem] font-extrabold text-secondary leading-tight">Thực chiến</div></div>
            </div>
            <div class="floaty2 absolute -bottom-5 -right-6 bg-base-100 border border-base-300 rounded-2xl shadow-xl py-3.5 px-[17px] items-center gap-3.5 hidden sm:flex">
              <span class="w-[42px] h-[42px] rounded-[11px] grid place-items-center bg-accent/10 text-accent"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg></span>
              <div><div class="text-[.76rem] text-base-content/50 font-medium">Hiệu suất vận hành</div><div class="text-[1.02rem] font-extrabold text-secondary leading-tight">Tối ưu cùng AI</div></div>
            </div>
          </div>
        </div>

        <!-- stats ribbon -->
        <div class="reveal in mt-16 stats stats-vertical sm:stats-horizontal bg-secondary text-secondary-content shadow-2xl rounded-[26px] w-full">
          <div class="stat place-items-center text-center">
            <div class="stat-value text-[clamp(1.8rem,2.6vw,2.5rem)]" data-count="4">0</div>
            <div class="stat-desc text-secondary-content/70 text-[.86rem]">Nhóm giải pháp AI For Work</div>
          </div>
          <div class="stat place-items-center text-center">
            <div class="stat-value text-[clamp(1.8rem,2.6vw,2.5rem)]" data-count="6">0</div>
            <div class="stat-desc text-secondary-content/70 text-[.86rem]">Bước triển khai đồng hành</div>
          </div>
          <div class="stat place-items-center text-center">
            <div class="stat-value text-[clamp(1.8rem,2.6vw,2.5rem)]"><span data-count="4">0</span> <span class="text-primary">Nhà</span></div>
            <div class="stat-desc text-secondary-content/70 text-[.86rem]">Hệ sinh thái nhân lực số</div>
          </div>
          <div class="stat place-items-center text-center">
            <div class="stat-value text-[clamp(1.8rem,2.6vw,2.5rem)]">2026<span class="text-primary">–35</span></div>
            <div class="stat-desc text-secondary-content/70 text-[.86rem]">Tầm nhìn phát triển nhân lực số</div>
          </div>
        </div>
      </div>
      <div class="h-[86px]"></div>
    </section>

    {{-- ============ PROBLEM ============ --}}
    <section class="py-24 bg-base-100">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <div class="reveal">
            <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary"><span class="w-7 h-0.5 bg-primary rounded"></span>Bối cảnh thị trường</span>
            <h2 class="font-extrabold text-secondary text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Khoảng cách giữa đào tạo và thực tiễn ngày càng lớn</h2>
            <p class="text-[1.1rem] text-base-content/60 text-pretty">Bằng cấp không còn là yếu tố duy nhất. Trong thời đại AI, thị trường ưu tiên khả năng thích nghi, tư duy thực tế và năng lực triển khai công việc — nhưng người học và doanh nghiệp vẫn đang gặp những rào cản thật.</p>
            <div class="flex flex-col gap-3.5 mt-7">
              <div class="flex gap-4 items-start bg-base-100 border border-base-300 rounded-2xl p-5 hover:shadow-md hover:translate-x-1 transition-all">
                <span class="w-10 h-10 rounded-[10px] bg-primary/10 text-primary grid place-items-center shrink-0"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span>
                <div><h4 class="text-[1.04rem] text-secondary font-bold mb-0.5">Người học thiếu trải nghiệm thực tế</h4><p class="text-[.92rem] text-base-content/60">Chương trình nặng lý thuyết, thiếu kỹ năng thực hành và khả năng thích nghi với môi trường làm việc.</p></div>
              </div>
              <div class="flex gap-4 items-start bg-base-100 border border-base-300 rounded-2xl p-5 hover:shadow-md hover:translate-x-1 transition-all">
                <span class="w-10 h-10 rounded-[10px] bg-primary/10 text-primary grid place-items-center shrink-0"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg></span>
                <div><h4 class="text-[1.04rem] text-secondary font-bold mb-0.5">Doanh nghiệp khó tuyển &amp; phải đào tạo lại</h4><p class="text-[.92rem] text-base-content/60">Thiếu nhân sự phù hợp, workflow chưa chuẩn hóa, dữ liệu phân tán và vận hành phụ thuộc con người.</p></div>
              </div>
              <div class="flex gap-4 items-start bg-base-100 border border-base-300 rounded-2xl p-5 hover:shadow-md hover:translate-x-1 transition-all">
                <span class="w-10 h-10 rounded-[10px] bg-primary/10 text-primary grid place-items-center shrink-0"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><line x1="2" y1="12" x2="22" y2="12"/></svg></span>
                <div><h4 class="text-[1.04rem] text-secondary font-bold mb-0.5">AI thay đổi cấu trúc công việc</h4><p class="text-[.92rem] text-base-content/60">Nhiều công việc lặp lại đang được tự động hóa; tổ chức cần năng lực ứng dụng AI vào công việc thật.</p></div>
              </div>
            </div>
          </div>
          <div class="reveal d2 rounded-[26px] p-11 text-white relative overflow-hidden bg-[linear-gradient(150deg,#2e3a5e_0%,#202942_100%)]">
            <div class="absolute -right-14 -bottom-14 w-60 h-60 rounded-full border-[36px] border-primary/12"></div>
            <div class="relative z-10 py-5.5 border-b border-white/15"><div class="text-[clamp(2.6rem,4vw,3.6rem)] font-extrabold leading-none text-primary">AI</div><p class="text-white/80 text-[.96rem] mt-1.5">không còn là xu hướng tương lai — mà đang trở thành hạ tầng vận hành mới của doanh nghiệp.</p></div>
            <div class="relative z-10 py-5.5 border-b border-white/15"><p class="text-[1.15rem] text-white font-semibold leading-snug">"Tương lai sẽ thuộc về những tổ chức và cá nhân biết học thật, làm thật và thích nghi thật."</p></div>
            <div class="relative z-10 pt-5.5"><p class="text-white/80 text-[.96rem]">THUCHOCVN được hình thành để thu hẹp khoảng cách đó — bằng đào tạo thực chiến, công nghệ AI và kết nối thực tiễn doanh nghiệp.</p></div>
          </div>
        </div>
      </div>
    </section>

    {{-- ============ PILLARS ============ --}}
    <section id="triet-ly" class="py-24" style="background:#FBF8F3">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="max-w-[760px] mx-auto text-center reveal">
          <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary justify-center"><span class="w-7 h-0.5 bg-primary rounded"></span>Triết lý phát triển</span>
          <h2 class="font-extrabold text-secondary text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Học thật — Làm thật — Giá trị thật</h2>
          <p class="text-[1.1rem] text-base-content/60 text-pretty">Không chỉ là thông điệp thương hiệu, đây là định hướng xuyên suốt mọi hoạt động: học gắn với ứng dụng, năng lực hình thành qua trải nghiệm, mục tiêu cuối cùng luôn là giá trị bền vững.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5.5 mt-13">
          <div class="card bg-base-100 border border-base-300 border-t-4 border-t-primary hover:shadow-md hover:-translate-y-1.5 transition-all reveal">
            <div class="card-body p-7"><span class="text-[.82rem] font-extrabold text-primary">01</span><span class="w-[54px] h-[54px] rounded-[14px] grid place-items-center my-3.5 bg-primary/10 text-primary"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></span><h3 class="text-[1.4rem] font-extrabold text-secondary mb-2">Học thật</h3><p class="text-[.96rem] text-base-content/60 text-pretty">Học tập gắn liền với trải nghiệm thực tiễn, kỹ năng triển khai và khả năng giải quyết vấn đề thật — không dừng ở lý thuyết.</p></div>
          </div>
          <div class="card bg-base-100 border border-base-300 border-t-4 border-t-accent hover:shadow-md hover:-translate-y-1.5 transition-all reveal d1">
            <div class="card-body p-7"><span class="text-[.82rem] font-extrabold text-accent">02</span><span class="w-[54px] h-[54px] rounded-[14px] grid place-items-center my-3.5 bg-accent/10 text-accent"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></span><h3 class="text-[1.4rem] font-extrabold text-secondary mb-2">Làm thật</h3><p class="text-[.96rem] text-base-content/60 text-pretty">Năng lực được tôi luyện qua va chạm thực tế: mentoring, thực tập, trải nghiệm nghề nghiệp và workflow thực chiến.</p></div>
          </div>
          <div class="card bg-base-100 border border-base-300 border-t-4 border-t-secondary hover:shadow-md hover:-translate-y-1.5 transition-all reveal d2">
            <div class="card-body p-7"><span class="text-[.82rem] font-extrabold text-secondary">03</span><span class="w-[54px] h-[54px] rounded-[14px] grid place-items-center my-3.5 bg-secondary/10 text-secondary"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></span><h3 class="text-[1.4rem] font-extrabold text-secondary mb-2">Giá trị thật</h3><p class="text-[.96rem] text-base-content/60 text-pretty">Mục tiêu cuối cùng không phải sự phức tạp, mà là nâng cao hiệu quả công việc và tạo ra giá trị bền vững cho con người.</p></div>
          </div>
          <div class="card bg-base-100 border border-base-300 border-t-4 border-t-primary hover:shadow-md hover:-translate-y-1.5 transition-all reveal d3">
            <div class="card-body p-7"><span class="text-[.82rem] font-extrabold text-primary">04</span><span class="w-[54px] h-[54px] rounded-[14px] grid place-items-center my-3.5 bg-primary/10 text-primary"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v1a3 3 0 0 0-3 3 3 3 0 0 0 0 6 3 3 0 0 0 3 3v1a3 3 0 0 0 6 0v-1a3 3 0 0 0 3-3 3 3 0 0 0 0-6 3 3 0 0 0-3-3V5a3 3 0 0 0-3-3z"/><path d="M12 8v8M9 12h6"/></svg></span><h3 class="text-[1.4rem] font-extrabold text-secondary mb-2">Ứng dụng AI thật</h3><p class="text-[.96rem] text-base-content/60 text-pretty">AI gần gũi, dễ triển khai và gắn với công việc cụ thể — không dừng ở lý thuyết hay trình diễn công nghệ.</p></div>
          </div>
        </div>
      </div>
    </section>

    {{-- ============ SOLUTIONS ============ --}}
    <section id="giai-phap" class="py-24 bg-base-100">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="max-w-[760px] mx-auto text-center reveal">
          <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary justify-center"><span class="w-7 h-0.5 bg-primary rounded"></span>Hệ sinh thái giải pháp</span>
          <h2 class="font-extrabold text-secondary text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Bốn trụ cột giải pháp AI For Work</h2>
          <p class="text-[1.1rem] text-base-content/60 text-pretty">Xoay quanh ba yếu tố cốt lõi — con người, công nghệ và hiệu suất làm việc — THUCHOCVN đồng hành từ vận hành doanh nghiệp đến phát triển nguồn nhân lực.</p>
        </div>
        <div class="grid lg:grid-cols-2 gap-6 mt-13">
          <div id="ai-ceo" class="group card bg-base-100 border border-base-300 hover:shadow-md hover:-translate-y-1.5 transition-all reveal scroll-mt-24">
            <div class="card-body p-9">
              <div class="flex items-center gap-4 mb-4"><span class="w-[58px] h-[58px] rounded-[15px] grid place-items-center shrink-0 bg-secondary text-secondary-content group-hover:bg-primary transition-colors"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="11" width="3" height="6" rx="1"/><rect x="12" y="7" width="3" height="10" rx="1"/><rect x="17" y="13" width="3" height="4" rx="1"/></svg></span><div><div class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">AI For CEO</div><h3 class="text-[1.46rem] font-extrabold text-secondary leading-tight">Quản trị &amp; điều hành</h3></div></div>
              <p class="text-[.97rem] text-base-content/60 mb-4 text-pretty">Hỗ trợ CEO và đội ngũ quản lý giảm tải hoạt động thủ công, nâng cao hiệu quả điều hành thông qua AI và workflow.</p>
              <div class="flex flex-wrap gap-2"><span class="badge badge-soft badge-secondary">Quản trị công việc</span><span class="badge badge-soft badge-secondary">Theo dõi tiến độ</span><span class="badge badge-soft badge-secondary">Workflow</span><span class="badge badge-soft badge-secondary">Quản lý dữ liệu</span><span class="badge badge-soft badge-secondary">Báo cáo &amp; ra quyết định</span></div>
              <a href="#ai-ceo" class="inline-flex items-center gap-2 mt-5 font-bold text-[.92rem] text-primary">Tìm hiểu thêm <svg class="group-hover:translate-x-1 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
          <div id="ai-sales" class="group card bg-base-100 border border-base-300 hover:shadow-md hover:-translate-y-1.5 transition-all reveal d1 scroll-mt-24">
            <div class="card-body p-9">
              <div class="flex items-center gap-4 mb-4"><span class="w-[58px] h-[58px] rounded-[15px] grid place-items-center shrink-0 bg-secondary text-secondary-content group-hover:bg-primary transition-colors"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg></span><div><div class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">AI For Sales</div><h3 class="text-[1.46rem] font-extrabold text-secondary leading-tight">Tăng trưởng bán hàng</h3></div></div>
              <p class="text-[.97rem] text-base-content/60 mb-4 text-pretty">Giúp đội ngũ bán hàng làm việc hiệu quả hơn và tăng khả năng chuyển đổi khách hàng bằng quy trình chuẩn hóa.</p>
              <div class="flex flex-wrap gap-2"><span class="badge badge-soft badge-secondary">Xây dựng nội dung</span><span class="badge badge-soft badge-secondary">Quản lý lead</span><span class="badge badge-soft badge-secondary">AI Follow-up</span><span class="badge badge-soft badge-secondary">AI Telesales</span><span class="badge badge-soft badge-secondary">Chuẩn hóa quy trình</span></div>
              <a href="#ai-sales" class="inline-flex items-center gap-2 mt-5 font-bold text-[.92rem] text-primary">Tìm hiểu thêm <svg class="group-hover:translate-x-1 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
          <div id="ai-training" class="group card bg-base-100 border border-base-300 hover:shadow-md hover:-translate-y-1.5 transition-all reveal scroll-mt-24">
            <div class="card-body p-9">
              <div class="flex items-center gap-4 mb-4"><span class="w-[58px] h-[58px] rounded-[15px] grid place-items-center shrink-0 bg-secondary text-secondary-content group-hover:bg-primary transition-colors"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span><div><div class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">AI Training</div><h3 class="text-[1.46rem] font-extrabold text-secondary leading-tight">Đào tạo AI thực chiến</h3></div></div>
              <p class="text-[.97rem] text-base-content/60 mb-4 text-pretty">Chương trình đào tạo ứng dụng AI thực tế cho doanh nghiệp, đội ngũ sales, startup, sinh viên và người lao động.</p>
              <div class="flex flex-wrap gap-2"><span class="badge badge-soft badge-secondary">AI For Work</span><span class="badge badge-soft badge-secondary">Prompt Engineering</span><span class="badge badge-soft badge-secondary">AI Workflow</span><span class="badge badge-soft badge-secondary">AI Productivity</span></div>
              <a href="#ai-training" class="inline-flex items-center gap-2 mt-5 font-bold text-[.92rem] text-primary">Tìm hiểu thêm <svg class="group-hover:translate-x-1 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
          <div id="workforce" class="group card bg-base-100 border border-base-300 hover:shadow-md hover:-translate-y-1.5 transition-all reveal d1 scroll-mt-24">
            <div class="card-body p-9">
              <div class="flex items-center gap-4 mb-4"><span class="w-[58px] h-[58px] rounded-[15px] grid place-items-center shrink-0 bg-secondary text-secondary-content group-hover:bg-primary transition-colors"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><div><div class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">Workforce Development</div><h3 class="text-[1.46rem] font-extrabold text-secondary leading-tight">Phát triển nhân lực</h3></div></div>
              <p class="text-[.97rem] text-base-content/60 mb-4 text-pretty">Phát triển nguồn nhân lực thực chiến, giúp người trẻ hiểu nghề, hiểu doanh nghiệp và thích nghi với thị trường hiện đại.</p>
              <div class="flex flex-wrap gap-2"><span class="badge badge-soft badge-secondary">Mentoring</span><span class="badge badge-soft badge-secondary">Định hướng nghề nghiệp</span><span class="badge badge-soft badge-secondary">Kết nối doanh nghiệp</span><span class="badge badge-soft badge-secondary">Thực tập có giám sát</span></div>
              <a href="#workforce" class="inline-flex items-center gap-2 mt-5 font-bold text-[.92rem] text-primary">Tìm hiểu thêm <svg class="group-hover:translate-x-1 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- ============ ECOSYSTEM ============ --}}
    <section class="py-24 bg-base-200">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="max-w-[760px] mx-auto text-center reveal">
          <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary justify-center"><span class="w-7 h-0.5 bg-primary rounded"></span>Mô hình hệ sinh thái</span>
          <h2 class="font-extrabold text-secondary text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Kết nối mô hình "4 Nhà"</h2>
          <p class="text-[1.1rem] text-base-content/60 text-pretty">Nền tảng số THUCHOCVN là trung tâm kết nối dữ liệu, cung cấp dịch vụ và hỗ trợ đào tạo — tuyển dụng giữa bốn chủ thể của hệ sinh thái nhân lực.</p>
        </div>
        <!-- desktop diagram -->
        <div class="hidden lg:block relative h-[520px] mt-8 reveal">
          <svg class="absolute inset-0 w-full h-full z-0" viewBox="0 0 100 100" preserveAspectRatio="none">
            <line x1="50" y1="50" x2="20" y2="20" stroke="rgba(46,58,94,.18)" stroke-width=".4" stroke-dasharray="1.4 1.4"/>
            <line x1="50" y1="50" x2="80" y2="20" stroke="rgba(46,58,94,.18)" stroke-width=".4" stroke-dasharray="1.4 1.4"/>
            <line x1="50" y1="50" x2="20" y2="80" stroke="rgba(46,58,94,.18)" stroke-width=".4" stroke-dasharray="1.4 1.4"/>
            <line x1="50" y1="50" x2="80" y2="80" stroke="rgba(46,58,94,.18)" stroke-width=".4" stroke-dasharray="1.4 1.4"/>
          </svg>
          <div class="absolute left-[20%] top-[20%] -translate-x-1/2 -translate-y-1/2 w-[210px] bg-base-100 border border-base-300 rounded-2xl p-5 shadow-sm hover:shadow-md hover:scale-[1.04] transition-all z-20"><span class="w-11 h-11 rounded-[11px] grid place-items-center bg-secondary/10 text-secondary mb-3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/></svg></span><h4 class="text-[1.08rem] text-secondary font-extrabold">Nhà nước</h4><p class="text-[.85rem] text-base-content/60 mt-1">Quản lý dữ liệu thị trường lao động, xây dựng chính sách.</p></div>
          <div class="absolute left-[80%] top-[20%] -translate-x-1/2 -translate-y-1/2 w-[210px] bg-base-100 border border-base-300 rounded-2xl p-5 shadow-sm hover:shadow-md hover:scale-[1.04] transition-all z-20"><span class="w-11 h-11 rounded-[11px] grid place-items-center bg-secondary/10 text-secondary mb-3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2.5 9 2.5 12 0v-5"/></svg></span><h4 class="text-[1.08rem] text-secondary font-extrabold">Nhà trường</h4><p class="text-[.85rem] text-base-content/60 mt-1">Quản lý thực tập, kết nối sinh viên với doanh nghiệp.</p></div>
          <div class="absolute left-[20%] top-[80%] -translate-x-1/2 -translate-y-1/2 w-[210px] bg-base-100 border border-base-300 rounded-2xl p-5 shadow-sm hover:shadow-md hover:scale-[1.04] transition-all z-20"><span class="w-11 h-11 rounded-[11px] grid place-items-center bg-secondary/10 text-secondary mb-3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg></span><h4 class="text-[1.08rem] text-secondary font-extrabold">Doanh nghiệp</h4><p class="text-[.85rem] text-base-content/60 mt-1">Tuyển dụng nhân lực, tham gia đào tạo thực hành.</p></div>
          <div class="absolute left-[80%] top-[80%] -translate-x-1/2 -translate-y-1/2 w-[210px] bg-base-100 border border-base-300 rounded-2xl p-5 shadow-sm hover:shadow-md hover:scale-[1.04] transition-all z-20"><span class="w-11 h-11 rounded-[11px] grid place-items-center bg-secondary/10 text-secondary mb-3"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 12 0v1"/></svg></span><h4 class="text-[1.08rem] text-secondary font-extrabold">Người học &amp; lao động</h4><p class="text-[.85rem] text-base-content/60 mt-1">Hồ sơ năng lực số, tìm cơ hội thực tập &amp; việc làm.</p></div>
          <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[230px] text-white text-center rounded-[20px] px-6 py-6.5 z-30 shadow-2xl bg-[linear-gradient(140deg,#f07a22,#c25c0c)]"><span class="w-13 h-13 rounded-[14px] grid place-items-center bg-white/20 mx-auto mb-3"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></span><h4 class="text-white text-[1.18rem] font-extrabold leading-tight">Nền tảng số THUCHOCVN</h4><p class="text-white/90 text-[.85rem] mt-1.5">Trung tâm kết nối dữ liệu &amp; dịch vụ</p></div>
        </div>
        <!-- mobile fallback -->
        <div class="lg:hidden grid gap-4 mt-8">
          <div class="text-white text-center rounded-[20px] px-6 py-6 shadow-xl bg-[linear-gradient(140deg,#f07a22,#c25c0c)]"><h4 class="text-white text-[1.15rem] font-extrabold">Nền tảng số THUCHOCVN</h4><p class="text-white/90 text-[.85rem] mt-1">Trung tâm kết nối dữ liệu &amp; dịch vụ</p></div>
          <div class="bg-base-100 border border-base-300 rounded-2xl p-5"><h4 class="text-[1.08rem] text-secondary font-extrabold">Nhà nước</h4><p class="text-[.85rem] text-base-content/60 mt-1">Quản lý dữ liệu thị trường lao động, xây dựng chính sách.</p></div>
          <div class="bg-base-100 border border-base-300 rounded-2xl p-5"><h4 class="text-[1.08rem] text-secondary font-extrabold">Nhà trường</h4><p class="text-[.85rem] text-base-content/60 mt-1">Quản lý thực tập, kết nối sinh viên với doanh nghiệp.</p></div>
          <div class="bg-base-100 border border-base-300 rounded-2xl p-5"><h4 class="text-[1.08rem] text-secondary font-extrabold">Doanh nghiệp</h4><p class="text-[.85rem] text-base-content/60 mt-1">Tuyển dụng nhân lực, tham gia đào tạo thực hành.</p></div>
          <div class="bg-base-100 border border-base-300 rounded-2xl p-5"><h4 class="text-[1.08rem] text-secondary font-extrabold">Người học &amp; lao động</h4><p class="text-[.85rem] text-base-content/60 mt-1">Hồ sơ năng lực số, tìm cơ hội thực tập &amp; việc làm.</p></div>
        </div>
      </div>
    </section>

    {{-- ============ PROCESS ============ --}}
    <section class="py-24 relative overflow-hidden text-white bg-[linear-gradient(180deg,#2e3a5e,#2e3a5e)]">
      <div class="absolute -left-40 -top-30 w-[480px] h-[480px] rounded-full bg-[radial-gradient(circle,rgba(21,160,136,.16),transparent_64%)]"></div>
      <div class="max-w-[1200px] mx-auto px-7 relative z-10">
        <div class="max-w-[760px] mx-auto text-center reveal">
          <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-[#FFB87A] justify-center"><span class="w-7 h-0.5 bg-primary rounded"></span>Mô hình triển khai</span>
          <h2 class="font-extrabold text-white text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Đồng hành thực tế trong 6 bước</h2>
          <p class="text-[1.1rem] text-white/75 text-pretty">THUCHOCVN không chỉ cung cấp giải pháp — chúng tôi đồng hành để tổ chức xây dựng năng lực vận hành và phát triển bền vững dài hạn.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-7.5 gap-y-6 mt-13">
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">01</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Khảo sát</h4><p class="text-white/70 text-[.93rem]">Đánh giá hiện trạng doanh nghiệp, nhu cầu thực tế và các pain point trong vận hành.</p></div>
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal d1"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">02</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Phân tích</h4><p class="text-white/70 text-[.93rem]">Xác định workflow cần tối ưu và các cơ hội ứng dụng AI phù hợp.</p></div>
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal d2"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">03</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Thiết kế giải pháp</h4><p class="text-white/70 text-[.93rem]">Thiết kế mô hình triển khai, workflow và hệ thống hỗ trợ phù hợp từng tổ chức.</p></div>
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">04</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Triển khai</h4><p class="text-white/70 text-[.93rem]">Setup công cụ, workflow và các giải pháp AI vào hoạt động thực tế.</p></div>
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal d1"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">05</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Đào tạo</h4><p class="text-white/70 text-[.93rem]">Hướng dẫn đội ngũ sử dụng công cụ và workflow trong công việc hằng ngày.</p></div>
          <div class="p-6.5 border border-white/15 rounded-2xl bg-white/5 hover:bg-white/10 hover:-translate-y-1.5 transition-all reveal d2"><div class="text-[2.4rem] font-extrabold text-primary/55 leading-none">06</div><h4 class="text-white text-[1.18rem] font-bold mt-2.5 mb-2">Đồng hành &amp; tối ưu</h4><p class="text-white/70 text-[.93rem]">Theo dõi hiệu quả, tối ưu workflow và hỗ trợ vận hành dài hạn.</p></div>
        </div>
      </div>
    </section>

    {{-- ============ ROADMAP ============ --}}
    <section id="lo-trinh" class="py-24 bg-base-100">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="max-w-[760px] mx-auto text-center reveal">
          <span class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[.16em] uppercase text-primary justify-center"><span class="w-7 h-0.5 bg-primary rounded"></span>Tầm nhìn 2026 – 2035</span>
          <h2 class="font-extrabold text-secondary text-[clamp(2.05rem,3.7vw,3rem)] leading-tight tracking-[-.01em] mt-4 mb-4 text-balance">Lộ trình kiến tạo hệ sinh thái nhân lực số</h2>
          <p class="text-[1.1rem] text-base-content/60 text-pretty">Từ thí điểm đến quy mô toàn quốc — hướng tới một nền tảng số thống nhất cho phát triển nguồn nhân lực Việt Nam.</p>
        </div>
        <div class="relative mt-16">
          <div class="hidden md:block absolute top-[26px] left-[16.66%] right-[16.66%] h-[3px] tl-line rounded"></div>
          <div class="grid md:grid-cols-3 gap-7">
            <!-- phase 1 -->
            <div class="relative md:pt-[74px] md:pl-0 pl-[74px] reveal">
              <span class="absolute top-0 md:left-1/2 left-0 md:-translate-x-1/2 w-[54px] h-[54px] rounded-full grid place-items-center font-extrabold text-xl bg-base-100 border-[3px] border-primary text-primary shadow-[0_6px_18px_rgba(240,122,34,.22)] z-20">1</span>
              <div class="bg-base-100 border border-base-300 rounded-2xl p-7 h-full hover:shadow-md hover:-translate-y-1.5 transition-all">
                <span class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">Giai đoạn 1 · 2026 – 2027</span>
                <h3 class="text-[1.32rem] font-extrabold text-secondary mt-1.5 mb-3 leading-tight">Thí điểm &amp; kiểm chứng mô hình</h3>
                <p class="text-[.96rem] text-base-content/60 text-pretty">Triển khai thí điểm tại một số địa phương, kiểm chứng mô hình đào tạo thực chiến và đặt nền móng cho hồ sơ năng lực số.</p>
                <div class="flex flex-col gap-2.5 my-5">
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Xây dựng hồ sơ năng lực số đầu tiên</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Chương trình đào tạo AI thực chiến</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Kết nối thí điểm trường – doanh nghiệp</span>
                </div>
                <div class="flex items-center gap-2.5 pt-4 border-t border-dashed border-base-300 text-[.84rem] text-base-content/50"><svg class="text-accent shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Định hướng quy mô: <b class="text-secondary font-bold">một số địa phương trọng điểm</b></div>
              </div>
            </div>
            <!-- phase 2 -->
            <div class="relative md:pt-[74px] md:pl-0 pl-[74px] reveal d1">
              <span class="absolute top-0 md:left-1/2 left-0 md:-translate-x-1/2 w-[54px] h-[54px] rounded-full grid place-items-center font-extrabold text-xl bg-base-100 border-[3px] border-[#8C99B5] text-secondary shadow-[0_6px_18px_rgba(46,58,94,.16)] z-20">2</span>
              <div class="bg-base-100 border border-base-300 rounded-2xl p-7 h-full hover:shadow-md hover:-translate-y-1.5 transition-all">
                <span class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-primary">Giai đoạn 2 · 2028 – 2030</span>
                <h3 class="text-[1.32rem] font-extrabold text-secondary mt-1.5 mb-3 leading-tight">Mở rộng trên phạm vi toàn quốc</h3>
                <p class="text-[.96rem] text-base-content/60 text-pretty">Nhân rộng mô hình toàn quốc, chuẩn hóa kết nối nhà trường – doanh nghiệp và hoàn thiện nền tảng dữ liệu nhân lực.</p>
                <div class="flex flex-col gap-2.5 my-5">
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Chuẩn hóa kết nối thực tập &amp; việc làm</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Hoàn thiện nền tảng dữ liệu nhân lực</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-secondary/90"><svg class="text-accent mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Phân tích xu hướng &amp; nhu cầu kỹ năng</span>
                </div>
                <div class="flex items-center gap-2.5 pt-4 border-t border-dashed border-base-300 text-[.84rem] text-base-content/50"><svg class="text-accent shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Định hướng quy mô: <b class="text-secondary font-bold">triển khai toàn quốc</b></div>
              </div>
            </div>
            <!-- phase 3 -->
            <div class="relative md:pt-[74px] md:pl-0 pl-[74px] reveal d2">
              <span class="absolute top-0 md:left-1/2 left-0 md:-translate-x-1/2 w-[54px] h-[54px] rounded-full grid place-items-center font-extrabold text-xl bg-accent border-[3px] border-accent text-accent-content shadow-[0_6px_18px_rgba(21,160,136,.3)] z-20">3</span>
              <div class="rounded-2xl p-7 h-full hover:-translate-y-1.5 transition-all text-white bg-[linear-gradient(160deg,#2e3a5e,#202942)]">
                <span class="text-[.74rem] font-extrabold tracking-[.1em] uppercase text-[#FFB87A]">Giai đoạn 3 · 2031 – 2035</span>
                <h3 class="text-[1.32rem] font-extrabold text-white mt-1.5 mb-3 leading-tight">Hệ sinh thái nhân lực số quốc gia</h3>
                <p class="text-[.96rem] text-white/80 text-pretty">Vận hành hệ sinh thái nhân lực số quốc gia với AI Workforce Platform, phục vụ dự báo và hoạch định chính sách nhân lực.</p>
                <div class="flex flex-col gap-2.5 my-5">
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-white/90"><svg class="text-[#5FD3BC] mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>AI Workforce Platform vận hành đầy đủ</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-white/90"><svg class="text-[#5FD3BC] mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dữ liệu thị trường lao động đồng bộ</span>
                  <span class="flex items-start gap-2.5 text-[.92rem] font-medium text-white/90"><svg class="text-[#5FD3BC] mt-0.5 shrink-0" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Hỗ trợ hoạch định chính sách nhân lực</span>
                </div>
                <div class="flex items-center gap-2.5 pt-4 border-t border-dashed border-white/20 text-[.84rem] text-white/60"><svg class="text-[#5FD3BC] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Định hướng: <b class="text-white font-bold">hệ sinh thái nhân lực số toàn quốc</b></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- ============ QUOTE ============ --}}
    <section class="py-20" style="background:#FBF8F3">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="max-w-[920px] mx-auto text-center reveal">
          <div class="text-[5rem] leading-[.5] text-primary font-extrabold" style="font-family:Georgia,serif">"</div>
          <blockquote class="text-[clamp(1.5rem,3vw,2.2rem)] font-bold text-secondary leading-snug tracking-[-.01em] my-3.5 mb-6.5 text-balance">Tương lai sẽ thuộc về những tổ chức và cá nhân biết học thật, làm thật và thích nghi thật.</blockquote>
          <div class="flex items-center gap-3.5 justify-center">
            <span class="w-13 h-13 rounded-full bg-secondary text-secondary-content grid place-items-center font-extrabold text-lg">LH</span>
            <div class="text-left"><b class="block text-secondary font-extrabold">Lê Thị Hà</b><span class="text-[.9rem] text-base-content/60">Founder &amp; CEO · THUCHOCVN</span></div>
          </div>
        </div>
      </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="py-24 bg-base-100">
      <div class="max-w-[1200px] mx-auto px-7">
        <div class="rounded-[30px] px-14 py-16 text-white relative overflow-hidden shadow-[0_30px_60px_rgba(240,122,34,.3)] bg-[linear-gradient(120deg,#f07a22_0%,#c25c0c_100%)] reveal">
          <div class="absolute -right-[70px] -top-[70px] w-[300px] h-[300px] rounded-full border-[44px] border-white/10"></div>
          <div class="relative z-10 max-w-[660px]">
            <h2 class="text-[clamp(1.9rem,3.4vw,2.8rem)] font-extrabold leading-tight mb-3.5 text-white">Sẵn sàng học thật, làm thật cùng AI?</h2>
            <p class="text-[1.1rem] opacity-95 mb-7.5">Đặt lịch tư vấn miễn phí để THUCHOCVN khảo sát hiện trạng và đề xuất lộ trình ứng dụng AI phù hợp cho tổ chức của bạn.</p>
            <div class="flex gap-3.5 flex-wrap">
              <a href="tel:0397791737" class="btn bg-base-100 text-secondary border-0 rounded-full hover:bg-base-100">Gọi 0397 791 737</a>
              <a href="{{ url('/contact') }}" class="btn btn-outline border-white/60 text-white hover:bg-white/15 hover:border-white rounded-full">Gửi yêu cầu tư vấn</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('portal::partials.footer')

</div>
@endsection
