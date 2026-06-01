@extends($themeMaster)

@section('head_extra')
    {{-- ai-readiness.js load trước app.js để window.aiReadiness sẵn trước Alpine.start() --}}
    @vite('resources/js/modules/ai-readiness.js')
    {{-- Fonts: preconnect trước, stylesheet load không blocking --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800&family=Space+Grotesk:wght@500;600;700&display=swap">
@endsection

@section('title', ($schema['title'] ?? 'Khảo sát AI Readiness') . ' — THUCHOCVN')
@section('meta_description', 'Khảo sát đánh giá mức độ sẵn sàng ứng dụng AI & tối ưu workflow cho doanh nghiệp.')

@section('content')
@php
/*
 * SVG icons dùng trong landing sections (static, không qua Alpine).
 * Survey + result sections vẫn dùng icon() từ Alpine component.
 */
$ico = [
  'spark'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/></svg>',
  'bolt'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 2L5 13h6l-1 9 8-11h-6l1-9z"/></svg>',
  'clock'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
  'shield'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 7.9-7 9-4-1.1-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>',
  'review'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3.5h6v1"/><path d="M8.5 13l2 2 4-4"/></svg>',
  'target'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="0.7" fill="currentColor"/></svg>',
  'map'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 3L3 5.5v15L9 18l6 2.5 6-2.5v-15L15 5.5 9 3z"/><path d="M9 3v15M15 5.5v15"/></svg>',
  'building' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="11" height="18" rx="1.5"/><path d="M15 8h4a1.5 1.5 0 0 1 1.5 1.5V21"/><path d="M8 7h3M8 11h3M8 15h3"/></svg>',
  'workflow' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="6" height="5" rx="1.2"/><rect x="15" y="4" width="6" height="5" rx="1.2"/><rect x="9" y="15" width="6" height="5" rx="1.2"/><path d="M6 9v2.5a1.5 1.5 0 0 0 1.5 1.5H11M18 9v2.5a1.5 1.5 0 0 1-1.5 1.5H13"/><path d="M12 13v2"/></svg>',
  'sales'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18"/><path d="M4 16l5-5 4 4 7-7"/><path d="M20 8V4h-4"/></svg>',
  'hr'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0"/><path d="M16 5.6a3 3 0 0 1 0 4.8"/><path d="M17.5 14.4a5.5 5.5 0 0 1 3 5.1"/></svg>',
  'data'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><ellipse cx="12" cy="5.5" rx="7" ry="3"/><path d="M5 5.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/><path d="M5 11.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/></svg>',
  'ai'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="6" width="12" height="12" rx="2.5"/><rect x="9.5" y="9.5" width="5" height="5" rx="1"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/></svg>',
];
$areas = [
  ['building', 'Thông tin doanh nghiệp', 'Mô hình, quy mô và định hướng vận hành.'],
  ['workflow',  'Workflow & Vận hành',    'Quy trình, SOP và điểm nghẽn vận hành.'],
  ['sales',     'Sales & Khách hàng',     'Lead, CRM và chất lượng chăm sóc khách.'],
  ['hr',        'Nhân sự & Đào tạo',      'Onboarding, KPI và hiệu suất đội ngũ.'],
  ['data',      'Dữ liệu & Hệ thống',     'Mức số hoá, tập trung và bảo mật dữ liệu.'],
  ['ai',        'AI Readiness',            'Mức độ sẵn sàng ứng dụng AI thực tế.'],
];
$deliverables = [
  ['review',   'Báo cáo phân tích tổng thể'],
  ['workflow',  'Sơ đồ Workflow & Data map'],
  ['ai',        'Đánh giá mức độ AI Readiness'],
  ['bolt',      'Đề xuất giải pháp AI phù hợp'],
  ['map',       'Lộ trình triển khai theo giai đoạn'],
  ['target',    'Ước tính ROI & hiệu quả'],
];
@endphp

<div style="font-family:'Be Vietnam Pro',system-ui,sans-serif">

{{-- ═══════════════════════════════════════════════════════════
     STATIC sections — render ngay, không cần Alpine, không x-cloak
     ═══════════════════════════════════════════════════════════ --}}

<!-- NAV -->
<div class="no-print sticky top-0 z-50 border-b border-base-300/70 bg-base-100/85 backdrop-blur-xl">
  <div class="mx-auto max-w-7xl px-5 h-16 flex items-center justify-between">
    <a href="#home" class="flex items-center gap-3 no-underline">
      <span class="grid place-items-center w-10 h-10 rounded-xl text-white font-display font-bold text-xl"
            style="background:linear-gradient(135deg,#2f6bff,#13b6e6)">T</span>
      <span class="leading-tight">
        <span class="block font-bold text-[17px] tracking-tight text-neutral">THUCHOCVN</span>
        <span class="block text-[10px] font-semibold tracking-[.14em] text-primary">HỌC THẬT · LÀM THẬT · GIÁ TRỊ THẬT</span>
      </span>
    </a>
    <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-neutral/70">
      <a class="hover:text-primary transition no-underline" href="#areas">Lĩnh vực</a>
      <a class="hover:text-primary transition no-underline" href="#process">Quy trình</a>
      <a class="hover:text-primary transition no-underline" href="#survey">Khảo sát</a>
      <a class="hover:text-primary transition no-underline" href="#pricing">Gói dịch vụ</a>
    </nav>
    <a href="#survey" class="btn btn-primary btn-sm rounded-full px-5 shadow-md shadow-primary/30">Bắt đầu</a>
  </div>
</div>

<!-- HERO -->
<header id="home" class="mesh hairline relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-6 pt-14 pb-16 lg:pt-20 lg:pb-24 grid lg:grid-cols-[1.05fr_.95fr] gap-12 items-center">
    <div>
      <span class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-4 py-1.5 text-xs font-bold tracking-wide text-primary">
        <span class="ico w-4 h-4">{!! $ico['spark'] !!}</span> AI FOR WORK &amp; WORKFORCE DEVELOPMENT
      </span>
      <h1 class="mt-6 font-display font-bold leading-[1.05] tracking-tight text-[2.6rem] sm:text-6xl text-neutral">
        Đánh giá <span class="text-grad">AI Readiness</span><br>&amp; Workflow doanh nghiệp
      </h1>
      <p class="mt-5 text-lg text-neutral/65 max-w-xl leading-relaxed">
        Bộ khảo sát chấm điểm 5 trục vận hành — trả về báo cáo, bản đồ điểm nghẽn, cơ hội AI và lộ trình triển khai cụ thể.
      </p>
      <div class="mt-7 flex flex-wrap items-center gap-3">
        <a href="#survey" class="btn btn-primary rounded-full px-7 text-base shadow-lg shadow-primary/30">
          <span class="ico w-5 h-5">{!! $ico['bolt'] !!}</span> Bắt đầu khảo sát
        </a>
        <a href="#areas" class="btn btn-ghost rounded-full px-6 text-base text-neutral/70">Xem 6 lĩnh vực</a>
      </div>
      <div class="mt-7 flex flex-wrap gap-x-7 gap-y-2 text-sm font-semibold text-neutral/55">
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-primary">{!! $ico['clock'] !!}</span> 15–20 phút</span>
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-success">{!! $ico['shield'] !!}</span> Bảo mật thông tin</span>
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-secondary">{!! $ico['review'] !!}</span> Báo cáo miễn phí</span>
      </div>
    </div>
    <!-- Preview card (static values) -->
    <div class="relative">
      <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-br from-primary/10 to-secondary/10 blur-xl"></div>
      <div class="relative rounded-[1.6rem] border border-base-300 bg-base-100/90 backdrop-blur p-6 shadow-2xl shadow-primary/10">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold tracking-wide text-neutral/50">BÁO CÁO MẪU</span>
          <span class="badge badge-sm badge-primary badge-soft font-semibold">AI Ready</span>
        </div>
        <div class="mt-3 flex items-center gap-5">
          <div class="radial-progress text-primary font-display" style="--value:78;--size:6.4rem;--thickness:8px" role="progressbar" aria-valuenow="78">
            <span class="text-2xl font-bold">78</span>
          </div>
          <div class="flex-1 space-y-2.5">
            @foreach([['Workflow',82],['Sales',68],['Dữ liệu',74]] as $bar)
            <div>
              <div class="flex justify-between text-[11px] font-semibold text-neutral/60">
                <span>{{ $bar[0] }}</span><span>{{ $bar[1] }}</span>
              </div>
              <div class="h-2 rounded-full bg-base-200 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary" style="width:{{ $bar[1] }}%"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="mt-4 grid grid-cols-3 gap-2 text-center">
          @foreach([['target','text-primary','Pain map'],['bolt','text-secondary','AI map'],['map','text-accent','Roadmap']] as $c)
          <div class="rounded-xl bg-base-200 p-2.5">
            <span class="ico w-5 h-5 mx-auto {{ $c[1] }}">{!! $ico[$c[0]] !!}</span>
            <div class="text-[10px] font-semibold text-neutral/60 mt-1">{{ $c[2] }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</header>

<!-- 6 LĨNH VỰC -->
<section id="areas" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">ĐÁNH GIÁ TOÀN DIỆN</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">6 lĩnh vực trọng tâm</h2>
    <p class="mt-3 text-neutral/60">Khảo sát chấm điểm và phân tích từng trục để bạn thấy rõ mình mạnh – yếu ở đâu.</p>
  </div>
  <div class="mt-9 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($areas as $a)
    <div class="group rounded-2xl border border-base-300 bg-base-100 p-5 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30">
      <span class="ico w-11 h-11 flex rounded-xl bg-primary/8 text-primary p-2.5 transition group-hover:bg-primary group-hover:text-white">{!! $ico[$a[0]] !!}</span>
      <h3 class="mt-4 font-bold text-neutral">{{ $a[1] }}</h3>
      <p class="mt-1.5 text-sm text-neutral/55 leading-relaxed">{{ $a[2] }}</p>
    </div>
    @endforeach
  </div>
</section>

<!-- QUY TRÌNH -->
<section id="process" class="bg-base-200/60 border-y border-base-300">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20 grid lg:grid-cols-2 gap-12">
    <div>
      <span class="text-sm font-bold tracking-wide text-primary">QUY TRÌNH</span>
      <h2 class="mt-2 font-display font-bold text-3xl tracking-tight text-neutral">4 bước, nhận kết quả nhanh</h2>
      <ol class="mt-8 space-y-5">
        @foreach([
          ['Điền khảo sát',   '15–20 phút, có thể lưu nháp giữa chừng.'],
          ['Phân tích',        'Hệ thống CRM chấm điểm tự động, 1–3 ngày.'],
          ['Nhận báo cáo',    'Báo cáo + radar + roadmap, 3–5 ngày.'],
          ['Tư vấn 1:1',      'Đồng hành chọn use case & triển khai.'],
        ] as $i => $s)
        <li class="flex gap-4">
          <span class="font-display font-bold text-lg w-10 h-10 grid place-items-center rounded-xl bg-primary/8 text-primary shrink-0">0{{ $i+1 }}</span>
          <div>
            <div class="font-bold text-neutral">{{ $s[0] }}</div>
            <div class="text-sm text-neutral/55 mt-0.5">{{ $s[1] }}</div>
          </div>
        </li>
        @endforeach
      </ol>
    </div>
    <div class="rounded-3xl border border-base-300 bg-base-100 p-7 lg:p-9 shadow-sm">
      <h3 class="font-display font-bold text-2xl tracking-tight text-neutral">Bạn sẽ nhận được</h3>
      <div class="mt-6 grid sm:grid-cols-2 gap-3">
        @foreach($deliverables as $g)
        <div class="flex items-center gap-3 rounded-xl bg-base-200 px-4 py-3">
          <span class="ico w-5 h-5 text-primary shrink-0">{!! $ico[$g[0]] !!}</span>
          <span class="text-sm font-semibold text-neutral/75">{{ $g[1] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     ALPINE section — x-cloak chỉ bao survey + result
     Landing đã hiển thị → người dùng không thấy trắng trang
     ═══════════════════════════════════════════════════════════ --}}

<!-- SURVEY + RESULT -->
@if($schema)
<div
    x-data="aiReadiness()"
    x-cloak
    data-schema='@json($schema)'
    data-submit-url="{{ $submitUrl ?? '' }}"
>

<section id="survey" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">KHẢO SÁT</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral" x-text="schema?.title ?? 'Đo điểm AI Readiness'"></h2>
    <p class="mt-3 text-neutral/60">Nội dung khảo sát được cấu hình từ CRM. Mỗi câu trả lời được chấm điểm tự động.</p>
  </div>

  <div class="mt-9 grid lg:grid-cols-[260px_1fr] gap-7 items-start">
    <!-- Sidebar desktop -->
    <aside class="hidden lg:block sticky top-20 no-print">
      <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
        <div class="flex items-center justify-between text-xs font-bold text-neutral/50 mb-3">
          <span>TIẾN TRÌNH</span><span x-text="(currentStep+1)+' / '+totalSteps"></span>
        </div>
        <ol class="space-y-1">
          <template x-for="(sec,i) in sections" :key="sec.id ?? i">
            <li>
              <button type="button" x-on:click="goTo(i)"
                class="w-full flex items-center gap-3 rounded-xl px-2.5 py-2 text-left transition"
                :class="i===currentStep ? 'bg-primary/8' : 'hover:bg-base-200'">
                <span class="w-6 h-6 rounded-lg grid place-items-center text-[11px] font-bold shrink-0"
                  :class="stepStatus(i)==='done' ? 'bg-success text-success-content' : stepStatus(i)==='active' ? 'bg-primary text-white' : 'bg-base-200 text-neutral/50'">
                  <template x-if="stepStatus(i)==='done'"><span class="ico w-3.5 h-3.5" x-html="icon('review')"></span></template>
                  <template x-if="stepStatus(i)!=='done'"><span x-text="i+1"></span></template>
                </span>
                <span class="text-sm font-semibold leading-tight"
                  :class="i===currentStep ? 'text-primary' : 'text-neutral/70'" x-text="sec.title"></span>
              </button>
            </li>
          </template>
        </ol>
      </div>
      <div class="mt-3 rounded-2xl border border-base-300 bg-base-100 p-4 text-sm">
        <div class="font-bold text-neutral mb-1.5">Cần hỗ trợ?</div>
        <p class="text-neutral/55 leading-relaxed">Đội ngũ THUCHOCVN sẵn sàng đồng hành.</p>
        <p class="mt-2 text-neutral/70 font-semibold leading-relaxed">0397 791 737<br>admin@thuchocvn.vn</p>
      </div>
    </aside>

    <!-- Form column -->
    <div x-show="!submitted">
      <!-- Sticky progress -->
      <div class="sticky top-[64px] z-30 no-print mb-4 rounded-2xl border border-base-300 bg-base-100/92 backdrop-blur px-4 py-3 shadow-sm">
        <div class="lg:hidden flex gap-1.5 overflow-x-auto pb-2 -mx-1 px-1">
          <template x-for="(sec,i) in sections" :key="'c'+(sec.id??i)">
            <button type="button" x-on:click="goTo(i)"
              class="shrink-0 w-7 h-7 rounded-lg grid place-items-center text-[11px] font-bold transition"
              :class="stepStatus(i)==='done' ? 'bg-success/15 text-success' : i===currentStep ? 'bg-primary text-white' : 'bg-base-200 text-neutral/45'"
              x-text="i+1"></button>
          </template>
        </div>
        <div class="flex items-center gap-3">
          <div class="flex-1">
            <div class="flex justify-between text-[11px] font-bold text-neutral/55 mb-1">
              <span x-text="'Phần '+(currentStep+1)+'/'+totalSteps+' · '+(currentSection?.title??'')"></span>
              <span>⏱ còn ~<span x-text="timeLeft"></span> phút</span>
            </div>
            <div class="h-2 rounded-full bg-base-200 overflow-hidden">
              <div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary transition-all duration-300"
                   :style="`width:${progress}%`"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Error banner -->
      <div x-show="loadError" x-cloak
        class="mb-4 rounded-2xl border border-error/20 bg-error/5 p-4 flex items-center gap-3 text-sm text-error font-medium">
        <span x-text="loadError"></span>
      </div>

      <!-- Form -->
      <form x-on:submit.prevent class="rounded-3xl border border-base-300 bg-base-100 p-5 sm:p-7 shadow-sm">
        <template x-for="(sec,si) in sections" :key="sec.id??si">
          <div x-show="currentStep===si" x-transition.opacity>
            <div class="flex items-start gap-3 pb-5 mb-6 border-b border-base-300">
              <div>
                <h3 class="font-display font-bold text-xl sm:text-2xl tracking-tight text-neutral">
                  <span x-text="(si+1)+'. '"></span><span x-text="sec.title"></span>
                </h3>
                <p class="text-sm text-neutral/55 mt-0.5" x-text="sec.description"></p>
              </div>
            </div>
            <div class="space-y-6">
              <template x-for="field in (sec.fields||[])" :key="field.id">
                <div x-show="isVisible(field)">
                  <label class="block text-sm font-bold text-neutral mb-2">
                    <span x-text="field.label"></span><span x-show="field.is_required" class="text-error"> *</span>
                  </label>
                  {{-- field_type 1: text --}}
                  <template x-if="field.field_type===1">
                    <input type="text" class="input input-bordered w-full" :class="errors[field.field_key]&&'input-error'"
                      :placeholder="field.placeholder||''" x-model="answers[field.field_key]"
                      x-on:input="delete errors[field.field_key]">
                  </template>
                  {{-- field_type 2: textarea --}}
                  <template x-if="field.field_type===2">
                    <textarea class="textarea textarea-bordered w-full min-h-[96px]" :class="errors[field.field_key]&&'textarea-error'"
                      :placeholder="field.placeholder||''" x-model="answers[field.field_key]"
                      x-on:input="delete errors[field.field_key]"></textarea>
                  </template>
                  {{-- field_type 3: number --}}
                  <template x-if="field.field_type===3">
                    <input type="number" class="input input-bordered w-full" :class="errors[field.field_key]&&'input-error'"
                      :min="field.rule_min" :max="field.rule_max" x-model.number="answers[field.field_key]"
                      x-on:input="delete errors[field.field_key]">
                  </template>
                  {{-- field_type 4: select --}}
                  <template x-if="field.field_type===4">
                    <select class="select select-bordered w-full" :class="errors[field.field_key]&&'select-error'"
                      x-model="answers[field.field_key]" x-on:change="delete errors[field.field_key]">
                      <option :value="null">-- Chọn --</option>
                      <template x-for="opt in (field.options||[])" :key="opt.id">
                        <option :value="opt.option_value" x-text="opt.label"></option>
                      </template>
                    </select>
                  </template>
                  {{-- field_type 5: radio --}}
                  <template x-if="field.field_type===5">
                    <div class="grid gap-2.5 grid-cols-1 sm:grid-cols-2">
                      <template x-for="opt in (field.options||[])" :key="opt.id">
                        <div class="opt rd" :class="isPick(field.field_key,opt.option_value)&&'on'"
                          x-on:click="pick(field.field_key,opt.option_value)">
                          <span class="tick" x-html="icon('check')"></span><span x-text="opt.label"></span>
                        </div>
                      </template>
                    </div>
                  </template>
                  {{-- field_type 6: checkbox --}}
                  <template x-if="field.field_type===6">
                    <div>
                      <div class="grid gap-2.5 grid-cols-1 sm:grid-cols-2">
                        <template x-for="opt in (field.options||[])" :key="opt.id">
                          <div class="opt" :class="isChecked(field.field_key,opt.option_value)&&'on'"
                            x-on:click="toggleCheck(field.field_key,opt.option_value,field.rule_max_select)">
                            <span class="tick" x-html="icon('check')"></span><span x-text="opt.label"></span>
                          </div>
                        </template>
                      </div>
                      <p x-show="field.rule_max_select" class="text-xs text-neutral/50 mt-1.5">
                        Chọn tối đa <span x-text="field.rule_max_select"></span> mục
                      </p>
                    </div>
                  </template>
                  {{-- field_type 7: rating --}}
                  <template x-if="field.field_type===7">
                    <div>
                      <div class="grid grid-cols-5 gap-2">
                        <template x-for="n in ratingRange(field)" :key="n">
                          <div class="rate" :class="isPick(field.field_key,n)&&'on'" x-on:click="pick(field.field_key,n)">
                            <span class="n" x-text="n"></span>
                          </div>
                        </template>
                      </div>
                      <p class="text-[11px] text-neutral/45 mt-1.5" x-text="ratingLabel(field)"></p>
                    </div>
                  </template>
                  {{-- field_type 8: date --}}
                  <template x-if="field.field_type===8">
                    <input type="date" class="input input-bordered w-full" :class="errors[field.field_key]&&'input-error'"
                      x-model="answers[field.field_key]" x-on:change="delete errors[field.field_key]">
                  </template>
                  {{-- field_type 9: boolean --}}
                  <template x-if="field.field_type===9">
                    <div class="flex gap-3">
                      <div class="opt rd flex-1 justify-center" :class="isPick(field.field_key,true)&&'on'"
                        x-on:click="pick(field.field_key,true)">
                        <span class="tick" x-html="icon('check')"></span><span class="font-semibold">Có</span>
                      </div>
                      <div class="opt rd flex-1 justify-center" :class="isPick(field.field_key,false)&&'on'"
                        x-on:click="pick(field.field_key,false)">
                        <span class="tick" x-html="icon('check')"></span><span class="font-semibold">Không</span>
                      </div>
                    </div>
                  </template>
                  <p x-show="errors[field.field_key]" x-cloak
                    class="text-error text-xs mt-1.5" x-text="errors[field.field_key]?.[0]"></p>
                </div>
              </template>
            </div>
          </div>
        </template>
        <!-- Nav -->
        <div class="no-print mt-8 pt-5 border-t border-base-300 flex items-center justify-between gap-3">
          <button type="button" x-on:click="prev()" class="btn btn-ghost rounded-full"
            :class="currentStep===0&&'invisible'">← Quay lại</button>
          <button type="button" x-on:click="saveDraft()"
            class="btn btn-ghost btn-sm rounded-full text-neutral/60 hidden sm:inline-flex">💾 Lưu nháp</button>
          <template x-if="currentStep<totalSteps-1">
            <button type="button" x-on:click="next()"
              class="btn btn-primary rounded-full px-7 shadow-md shadow-primary/30">Tiếp tục →</button>
          </template>
          <template x-if="currentStep===totalSteps-1">
            <button type="button" x-on:click="submit()"
              class="btn btn-primary rounded-full px-7 shadow-lg shadow-primary/30" :disabled="submitting">
              <span x-show="submitting" class="loading loading-spinner loading-sm"></span>
              <span x-text="submitting?'Đang gửi...':'Gửi khảo sát'"></span>
            </button>
          </template>
        </div>
      </form>
    </div>
    <div x-show="submitted" class="text-center py-10 text-success">
      <p class="font-bold text-lg">✅ Đã gửi — xem báo cáo bên dưới.</p>
    </div>
  </div>
</section>

<!-- RESULT -->
<section id="result" x-show="submitted" x-cloak class="bg-base-200/60 border-y border-base-300">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20">

    {{-- ── Trạng thái 1: Đang chờ chấm điểm (poll CRM) ── --}}
    <template x-if="scoringPending">
      <div class="max-w-lg mx-auto">
        <div class="rounded-3xl border border-base-300 bg-base-100 p-10 shadow-sm">

          {{-- Animated icon --}}
          <div class="relative w-24 h-24 mx-auto mb-7">
            <span class="absolute inset-0 rounded-full bg-primary/20 animate-ping"></span>
            <span class="absolute inset-3 rounded-full bg-primary/25 animate-ping [animation-delay:400ms]"></span>
            <span class="relative flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary shadow-lg shadow-primary/30">
              <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <rect x="6" y="6" width="12" height="12" rx="2.5"/><rect x="9.5" y="9.5" width="5" height="5" rx="1"/>
                <path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/>
              </svg>
            </span>
          </div>

          <h3 class="font-display font-bold text-2xl text-neutral text-center">Đang phân tích kết quả</h3>
          <p class="mt-2 text-center text-base-content/55 text-sm">Hệ thống đang chấm điểm câu trả lời trên 5 trục vận hành</p>

          {{-- Indeterminate progress bar --}}
          <progress class="progress progress-primary w-full mt-6"></progress>

          {{-- Processing steps --}}
          <ul class="mt-7 space-y-3">
            {{-- Luôn done --}}
            <li class="flex items-center gap-3 text-sm text-success font-medium">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-success text-success-content text-xs font-bold">✓</span>
              Thu thập &amp; xác thực câu trả lời
            </li>
            {{-- Done sau lần poll 1 --}}
            <li class="flex items-center gap-3 text-sm font-medium transition-colors duration-500"
                :class="pollAttempt >= 1 ? 'text-success' : 'text-base-content/40'">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold transition-colors duration-500"
                    :class="pollAttempt >= 1 ? 'bg-success text-success-content' : 'border-2 border-base-300'">
                <template x-if="pollAttempt >= 1"><span>✓</span></template>
                <template x-if="pollAttempt < 1"><span>2</span></template>
              </span>
              Phân tích Workflow &amp; Dữ liệu
            </li>
            {{-- Active: đang tính điểm --}}
            <li class="flex items-center gap-3 text-sm font-medium"
                :class="pollAttempt >= 3 ? 'text-success' : 'text-primary'">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                    :class="pollAttempt >= 3 ? 'bg-success text-success-content' : 'bg-primary/10 text-primary'">
                <template x-if="pollAttempt >= 3"><span>✓</span></template>
                <template x-if="pollAttempt < 3">
                  <span class="loading loading-spinner loading-xs"></span>
                </template>
              </span>
              Tính điểm AI Readiness theo 5 trục
            </li>
            {{-- Pending --}}
            <li class="flex items-center gap-3 text-sm font-medium text-base-content/40"
                :class="pollAttempt >= 5 ? 'text-primary' : ''">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-base-300 text-xs font-bold"
                    :class="pollAttempt >= 5 ? 'border-primary/50 text-primary' : ''">
                <template x-if="pollAttempt >= 5">
                  <span class="loading loading-spinner loading-xs"></span>
                </template>
                <template x-if="pollAttempt < 5"><span>4</span></template>
              </span>
              Tổng hợp báo cáo &amp; lộ trình
            </li>
          </ul>

          <p class="mt-7 text-center text-xs text-base-content/35">Thường mất 30–60 giây · Đừng đóng trang này</p>
        </div>
      </div>
    </template>

    {{-- ── Trạng thái 2: Đã có điểm từ CRM ── --}}
    <template x-if="!scoringPending && hasScores">
      <div>
        <div class="max-w-2xl mb-8">
          <span class="text-sm font-bold tracking-wide text-primary">KẾT QUẢ</span>
          <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">Báo cáo AI Readiness</h2>
        </div>
        <div class="grid lg:grid-cols-12 gap-5">
          <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-7 text-center">
            <div class="radial-progress text-primary font-display mx-auto"
                :style="`--value:${resultOverall};--size:9rem;--thickness:11px`" role="progressbar">
              <span class="text-4xl font-bold" x-text="resultOverall"></span>
            </div>
            <h3 class="mt-4 font-display font-bold text-2xl text-neutral" x-text="resultLevel?.name??''"></h3>
            <div class="mt-1.5 inline-flex flex-wrap justify-center gap-1.5">
              <template x-for="(l,i) in ['Manual','Foundation','AI Ready','Transformation']" :key="i">
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full"
                  :class="i===(resultLevel?.idx??-1)?'bg-primary text-white':'bg-base-200 text-neutral/40'"
                  x-text="l"></span>
              </template>
            </div>
            <p class="mt-4 text-sm text-neutral/60 leading-relaxed text-left" x-text="resultLevel?.desc??''"></p>
            <button x-on:click="printReport()" class="btn btn-outline btn-primary btn-sm rounded-full mt-5 no-print">In / Lưu PDF</button>
          </div>
          <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-6">
            <h3 class="font-bold text-neutral mb-2">Radar 5 trục</h3>
            <div id="radarChart" style="height:260px;width:100%"></div>
          </div>
          <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-6">
            <h3 class="font-bold text-neutral mb-4">Điểm từng nhóm</h3>
            <div class="space-y-4">
              <template x-for="b in resultBars" :key="b.k">
                <div>
                  <div class="flex justify-between text-sm font-semibold text-neutral/70">
                    <span x-text="b.label"></span><span class="font-display" x-text="b.val"></span>
                  </div>
                  <div class="h-2.5 rounded-full bg-base-200 mt-1.5 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary" :style="`width:${b.val}%`"></div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
        {{-- Roadmap từ CRM (nếu có) --}}
        <template x-if="resultRoadmap.length > 0">
          <div class="mt-5 grid sm:grid-cols-3 gap-4">
            <template x-for="(phase, pi) in resultRoadmap" :key="phase.phase_code ?? pi">
              <div class="rounded-3xl border border-base-300 bg-base-100 p-5">
                <div class="flex items-center gap-2 mb-3">
                  <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-primary-content font-display font-bold text-sm"
                        x-text="pi + 1"></span>
                  <h4 class="font-bold text-sm text-neutral leading-tight" x-text="phase.title"></h4>
                </div>
                <p x-show="phase.description" class="text-xs text-neutral/55 leading-relaxed" x-text="phase.description"></p>
                <ul x-show="phase.actions && phase.actions.length" class="mt-2 space-y-1">
                  <template x-for="(action, ai) in (phase.actions || [])" :key="ai">
                    <li class="flex items-start gap-1.5 text-xs text-neutral/65">
                      <span class="mt-0.5 text-primary">·</span><span x-text="action"></span>
                    </li>
                  </template>
                </ul>
              </div>
            </template>
          </div>
        </template>

        <div class="mt-5 rounded-3xl border border-primary/20 bg-gradient-to-br from-primary/5 to-secondary/5 p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
          <div class="max-w-2xl">
            <h3 class="font-bold text-neutral">Gói tư vấn đề xuất</h3>
            <p class="mt-2 text-sm text-neutral/65 leading-relaxed" x-text="resultLevel?.pkg??''"></p>
          </div>
          <div class="flex gap-2 shrink-0 no-print">
            <button x-on:click="redo()" class="btn btn-ghost rounded-full">Làm lại</button>
            <a href="#contact" class="btn btn-primary rounded-full px-6">Đặt lịch tư vấn</a>
          </div>
        </div>
      </div>
    </template>

    {{-- ── Trạng thái 3: Timeout — CRM chưa trả điểm sau 60 giây ── --}}
    <template x-if="!scoringPending && !hasScores">
      <div class="max-w-xl mx-auto text-center">
        <div class="rounded-3xl border border-base-300 bg-base-100 p-10 shadow-sm">
          <div class="text-6xl mb-5">🎉</div>
          <h3 class="font-display font-bold text-2xl text-neutral mb-3">Khảo sát đã ghi nhận!</h3>
          <p class="text-neutral/60 text-sm mb-2">Câu trả lời của bạn đã được lưu thành công vào hệ thống.</p>
          <p x-show="result?.response_id" class="text-xs text-neutral/40 mt-1">
            Mã phản hồi: #<span x-text="result?.response_id"></span>
          </p>
          <div class="mt-6 rounded-2xl bg-primary/5 border border-primary/15 p-4 text-sm text-neutral/70 leading-relaxed">
            Chuyên gia THUCHOCVN sẽ hoàn thiện báo cáo AI Readiness và gửi cho bạn trong <strong class="text-primary">1–3 ngày làm việc</strong>.
          </div>
          <div class="mt-7 flex justify-center gap-3">
            <button x-on:click="redo()" class="btn btn-ghost rounded-full btn-sm">Làm lại khảo sát</button>
            <a href="#contact" class="btn btn-primary rounded-full px-6">Đặt lịch tư vấn 1:1</a>
          </div>
        </div>
      </div>
    </template>
  </div>
</section>

<!-- Toast -->
<div class="no-print fixed bottom-5 left-1/2 -translate-x-1/2 z-[60]" x-show="toast" x-transition x-cloak>
  <div class="rounded-full bg-neutral text-neutral-content px-5 py-2.5 text-sm font-semibold shadow-xl" x-text="toast"></div>
</div>

</div>{{-- /x-data="aiReadiness()" --}}

@else
{{-- CRM không kết nối được: fallback tĩnh cho survey section --}}
<section id="survey" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="rounded-2xl border border-warning/30 bg-warning/5 p-8 text-center max-w-lg mx-auto">
    <div class="text-4xl mb-3">⚠️</div>
    <h3 class="font-bold text-neutral mb-2">Chưa tải được dữ liệu khảo sát</h3>
    <p class="text-neutral/60 text-sm mb-4">Vui lòng thử lại sau hoặc liên hệ hỗ trợ.</p>
    <a href="tel:0397791737" class="btn btn-primary rounded-full px-6">0397 791 737</a>
  </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════
     STATIC sections dưới — render ngay sau Alpine section
     ═══════════════════════════════════════════════════════════ --}}

<!-- PRICING -->
<section id="pricing" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">GÓI DỊCH VỤ</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">Từ đánh giá đến triển khai</h2>
  </div>
  <div class="mt-9 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach([
      ['START',  'primary', 'AI Workflow Audit',              'Khảo sát, scoring, báo cáo hiện trạng.',              'Mới bắt đầu'],
      ['SETUP',  'success', 'Digital Workflow Foundation',    'SOP, CRM, dashboard, dữ liệu cơ bản.',                'Nền tảng số'],
      ['PILOT',  'accent',  'AI Workflow Implementation',     'Triển khai AI cho 1–2 use case ROI nhanh.',           'Sẵn sàng AI'],
      ['SCALE',  'warning', 'AI Transformation Program',      'AI OS, Agent, Dashboard, Automation Center.',         'Scale toàn diện'],
    ] as $p)
    <div class="rounded-2xl border border-base-300 bg-base-100 p-6 flex flex-col transition hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10">
      <span class="self-start text-[11px] font-bold px-2.5 py-1 rounded-full bg-{{ $p[1] }}/12 text-{{ $p[1] }}">{{ $p[0] }}</span>
      <h3 class="mt-4 font-bold text-lg text-neutral leading-snug">{{ $p[2] }}</h3>
      <p class="mt-2 text-sm text-neutral/55 leading-relaxed flex-1">{{ $p[3] }}</p>
      <div class="mt-4 pt-4 border-t border-base-300 text-sm font-semibold text-neutral/70">Phù hợp: {{ $p[4] }}</div>
    </div>
    @endforeach
  </div>
</section>

<!-- FOOTER -->
<footer id="contact" class="bg-neutral text-neutral-content">
  <div class="mx-auto max-w-7xl px-6 py-12 grid md:grid-cols-4 gap-8 items-start">
    <div>
      <div class="flex items-center gap-2.5">
        <span class="grid place-items-center w-9 h-9 rounded-lg text-white font-display font-bold"
              style="background:linear-gradient(135deg,#2f6bff,#13b6e6)">T</span>
        <span class="font-bold text-lg">THUCHOCVN</span>
      </div>
      <p class="mt-3 text-sm text-neutral-content/60">Học thật · Làm thật · Giá trị thật</p>
    </div>
    <div class="text-sm"><div class="text-neutral-content/45 font-semibold">Website</div><div class="font-semibold mt-1">thuchocvn.vn</div></div>
    <div class="text-sm"><div class="text-neutral-content/45 font-semibold">Email</div><div class="font-semibold mt-1">admin@thuchocvn.vn</div></div>
    <div class="text-sm">
      <div class="text-neutral-content/45 font-semibold">Hotline</div>
      <div class="font-semibold mt-1">0397 791 737</div>
      <div class="text-neutral-content/45 mt-1">08:00 – 17:30</div>
    </div>
  </div>
  <div class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-6 py-4 text-xs text-neutral-content/40">
      © {{ date('Y') }} THUCHOCVN · AI for Work &amp; Workforce Development
    </div>
  </div>
</footer>

</div>{{-- /outer wrapper --}}
@endsection
