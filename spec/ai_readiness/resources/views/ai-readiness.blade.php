<!DOCTYPE html>
<html lang="vi" data-theme="thuchoc">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>THUCHOCVN · Khảo sát AI Readiness & Workflow</title>
  <meta name="description" content="Khảo sát đánh giá mức độ sẵn sàng ứng dụng AI & tối ưu workflow cho doanh nghiệp." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="surveyApp()" x-cloak>

<!-- ===== NAV ===== -->
<div class="no-print sticky top-0 z-50 border-b border-base-300/70 bg-base-100/85 backdrop-blur-xl">
  <div class="mx-auto max-w-7xl px-5 h-16 flex items-center justify-between">
    <a href="#home" class="flex items-center gap-3">
      <span class="grid place-items-center w-10 h-10 rounded-xl text-white font-display font-bold text-xl" style="background:linear-gradient(135deg,#2f6bff,#13b6e6)">T</span>
      <span class="leading-tight">
        <span class="block font-bold text-[17px] tracking-tight text-neutral">THUCHOCVN</span>
        <span class="block text-[10px] font-semibold tracking-[.14em] text-primary">HỌC THẬT · LÀM THẬT · GIÁ TRỊ THẬT</span>
      </span>
    </a>
    <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-neutral/70">
      <a class="hover:text-primary transition" href="#areas">Lĩnh vực</a>
      <a class="hover:text-primary transition" href="#process">Quy trình</a>
      <a class="hover:text-primary transition" href="#survey">Khảo sát</a>
      <a class="hover:text-primary transition" href="#pricing">Gói dịch vụ</a>
    </nav>
    <a href="#survey" class="btn btn-primary btn-sm rounded-full px-5 shadow-md shadow-primary/30">Bắt đầu</a>
  </div>
</div>

<!-- ===== HERO ===== -->
<header id="home" class="mesh hairline relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-6 pt-14 pb-16 lg:pt-20 lg:pb-24 grid lg:grid-cols-[1.05fr_.95fr] gap-12 items-center">
    <div>
      <span class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-4 py-1.5 text-xs font-bold tracking-wide text-primary">
        <span class="ico w-4 h-4" x-html="icon('spark')"></span> AI FOR WORK &amp; WORKFORCE DEVELOPMENT
      </span>
      <h1 class="mt-6 font-display font-bold leading-[1.05] tracking-tight text-[2.6rem] sm:text-6xl text-neutral">
        Đánh giá <span class="text-grad">AI Readiness</span><br>&amp; Workflow doanh nghiệp
      </h1>
      <p class="mt-5 text-lg text-neutral/65 max-w-xl leading-relaxed">
        Một bộ khảo sát thông minh chấm điểm 5 trục vận hành của bạn — và trả về báo cáo, bản đồ điểm nghẽn, cơ hội AI cùng lộ trình triển khai cụ thể.
      </p>
      <div class="mt-7 flex flex-wrap items-center gap-3">
        <a href="#survey" class="btn btn-primary rounded-full px-7 text-base shadow-lg shadow-primary/30">
          <span class="ico w-5 h-5" x-html="icon('bolt')"></span> Bắt đầu khảo sát
        </a>
        <a href="#areas" class="btn btn-ghost rounded-full px-6 text-base text-neutral/70">Xem 6 lĩnh vực</a>
      </div>
      <div class="mt-7 flex flex-wrap gap-x-7 gap-y-2 text-sm font-semibold text-neutral/55">
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-primary" x-html="icon('clock')"></span> 15–20 phút</span>
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-success" x-html="icon('shield')"></span> Bảo mật thông tin</span>
        <span class="inline-flex items-center gap-2"><span class="ico w-4 h-4 text-secondary" x-html="icon('review')"></span> Báo cáo miễn phí</span>
      </div>
    </div>

    <!-- report preview card -->
    <div class="relative">
      <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-br from-primary/10 to-secondary/10 blur-xl"></div>
      <div class="relative rounded-[1.6rem] border border-base-300 bg-base-100/90 backdrop-blur p-6 shadow-2xl shadow-primary/10">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold tracking-wide text-neutral/50">BÁO CÁO MẪU</span>
          <span class="badge badge-sm badge-primary badge-soft font-semibold">AI Ready</span>
        </div>
        <div class="mt-3 flex items-center gap-5">
          <div class="radial-progress text-primary font-display" style="--value:78;--size:6.4rem;--thickness:8px" role="progressbar">
            <span class="text-2xl font-bold">78</span>
          </div>
          <div class="flex-1 space-y-2.5">
            <template x-for="r in [['Workflow',82],['Sales',68],['Dữ liệu',74]]" :key="r[0]">
              <div>
                <div class="flex justify-between text-[11px] font-semibold text-neutral/60"><span x-text="r[0]"></span><span x-text="r[1]"></span></div>
                <div class="h-2 rounded-full bg-base-200 overflow-hidden"><div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary" :style="`width:${r[1]}%`"></div></div>
              </div>
            </template>
          </div>
        </div>
        <div class="mt-4 grid grid-cols-3 gap-2 text-center">
          <div class="rounded-xl bg-base-200 p-2.5"><div class="ico w-5 h-5 mx-auto text-primary" x-html="icon('target')"></div><div class="text-[10px] font-semibold text-neutral/60 mt-1">Pain map</div></div>
          <div class="rounded-xl bg-base-200 p-2.5"><div class="ico w-5 h-5 mx-auto text-secondary" x-html="icon('bolt')"></div><div class="text-[10px] font-semibold text-neutral/60 mt-1">AI map</div></div>
          <div class="rounded-xl bg-base-200 p-2.5"><div class="ico w-5 h-5 mx-auto text-accent" x-html="icon('map')"></div><div class="text-[10px] font-semibold text-neutral/60 mt-1">Roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ===== AREAS (marketing) ===== -->
<section id="areas" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">ĐÁNH GIÁ TOÀN DIỆN</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">6 lĩnh vực trọng tâm</h2>
    <p class="mt-3 text-neutral/60">Khảo sát chấm điểm và phân tích từng trục để bạn thấy rõ mình mạnh – yếu ở đâu.</p>
  </div>
  <div class="mt-9 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <template x-for="(a,i) in [
      ['building','Thông tin doanh nghiệp','Mô hình, quy mô và định hướng vận hành.'],
      ['workflow','Workflow & Vận hành','Quy trình, SOP và điểm nghẽn vận hành.'],
      ['sales','Sales & Khách hàng','Lead, CRM và chất lượng chăm sóc khách.'],
      ['hr','Nhân sự & Đào tạo','Onboarding, KPI và hiệu suất đội ngũ.'],
      ['data','Dữ liệu & Hệ thống','Mức số hoá, tập trung và bảo mật dữ liệu.'],
      ['ai','AI Readiness','Mức độ sẵn sàng ứng dụng AI thực tế.']
    ]" :key="i">
      <div class="group rounded-2xl border border-base-300 bg-base-100 p-5 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30">
        <div class="ico w-11 h-11 rounded-xl bg-primary/8 text-primary p-2.5 transition group-hover:bg-primary group-hover:text-white" x-html="icon(a[0])"></div>
        <h3 class="mt-4 font-bold text-neutral" x-text="a[1]"></h3>
        <p class="mt-1.5 text-sm text-neutral/55 leading-relaxed" x-text="a[2]"></p>
      </div>
    </template>
  </div>
</section>

<!-- ===== PROCESS + WHAT YOU GET (marketing) ===== -->
<section id="process" class="bg-base-200/60 border-y border-base-300">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20 grid lg:grid-cols-2 gap-12">
    <div>
      <span class="text-sm font-bold tracking-wide text-primary">QUY TRÌNH</span>
      <h2 class="mt-2 font-display font-bold text-3xl tracking-tight text-neutral">4 bước, nhận kết quả nhanh</h2>
      <ol class="mt-8 space-y-5">
        <template x-for="(s,i) in [
          ['Điền khảo sát','15–20 phút, có thể lưu nháp giữa chừng.'],
          ['Phân tích','Đội ngũ chấm điểm & đối chiếu, 1–3 ngày.'],
          ['Nhận báo cáo','Báo cáo + radar + roadmap, 3–5 ngày.'],
          ['Tư vấn 1:1','Đồng hành chọn use case & triển khai.']
        ]" :key="i">
          <li class="flex gap-4">
            <span class="font-display font-bold text-lg w-10 h-10 grid place-items-center rounded-xl bg-primary/8 text-primary shrink-0" x-text="'0'+(i+1)"></span>
            <div><div class="font-bold text-neutral" x-text="s[0]"></div><div class="text-sm text-neutral/55 mt-0.5" x-text="s[1]"></div></div>
          </li>
        </template>
      </ol>
    </div>
    <div class="rounded-3xl border border-base-300 bg-base-100 p-7 lg:p-9 shadow-sm">
      <h3 class="font-display font-bold text-2xl tracking-tight text-neutral">Bạn sẽ nhận được</h3>
      <div class="mt-6 grid sm:grid-cols-2 gap-3">
        <template x-for="(g,i) in [
          ['review','Báo cáo phân tích tổng thể'],
          ['workflow','Sơ đồ Workflow & Data map'],
          ['ai','Đánh giá mức độ AI Readiness'],
          ['bolt','Đề xuất giải pháp AI phù hợp'],
          ['map','Lộ trình triển khai theo giai đoạn'],
          ['target','Ước tính ROI & hiệu quả']
        ]" :key="i">
          <div class="flex items-center gap-3 rounded-xl bg-base-200 px-4 py-3">
            <span class="ico w-5 h-5 text-primary shrink-0" x-html="icon(g[0])"></span>
            <span class="text-sm font-semibold text-neutral/75" x-text="g[1]"></span>
          </div>
        </template>
      </div>
    </div>
  </div>
</section>

<!-- ===== SURVEY ===== -->
<section id="survey" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">KHẢO SÁT</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">Đo điểm AI Readiness của bạn</h2>
    <p class="mt-3 text-neutral/60">Mỗi lựa chọn cập nhật điểm tạm tính ngay lập tức. Trả lời thật để báo cáo chính xác.</p>
  </div>

  <div class="mt-9 grid lg:grid-cols-[260px_1fr] gap-7 items-start">
    <!-- sidebar (desktop) -->
    <aside class="hidden lg:block sticky top-20 no-print">
      <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
        <div class="flex items-center justify-between text-xs font-bold text-neutral/50 mb-3">
          <span>TIẾN TRÌNH</span><span x-text="(current+1)+' / '+sections.length"></span>
        </div>
        <ol class="space-y-1">
          <template x-for="(sec,i) in sections" :key="i">
            <li>
              <button type="button" x-on:click="goTo(i)" class="w-full flex items-center gap-3 rounded-xl px-2.5 py-2 text-left transition"
                :class="i===current ? 'bg-primary/8' : 'hover:bg-base-200'">
                <span class="stepdot w-6 h-6 rounded-lg grid place-items-center text-[11px] font-bold shrink-0"
                  :class="stepStatus(i)==='done' ? 'bg-success text-success-content' : stepStatus(i)==='active' ? 'bg-primary text-white' : 'bg-base-200 text-neutral/50'">
                  <template x-if="stepStatus(i)==='done'"><span class="ico w-3.5 h-3.5" x-html="icon('review')"></span></template>
                  <template x-if="stepStatus(i)!=='done'"><span x-text="i+1"></span></template>
                </span>
                <span class="text-sm font-semibold leading-tight" :class="i===current ? 'text-primary' : 'text-neutral/70'" x-text="sec.title"></span>
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

    <!-- form column -->
    <div>
      <!-- sticky progress header -->
      <div class="sticky top-[64px] z-30 no-print mb-4 rounded-2xl border border-base-300 bg-base-100/92 backdrop-blur px-4 py-3 shadow-sm">
        <!-- mobile step chips -->
        <div class="lg:hidden flex gap-1.5 overflow-x-auto pb-2 -mx-1 px-1">
          <template x-for="(sec,i) in sections" :key="'c'+i">
            <button type="button" x-on:click="goTo(i)" class="shrink-0 w-7 h-7 rounded-lg grid place-items-center text-[11px] font-bold transition"
              :class="stepStatus(i)==='done' ? 'bg-success/15 text-success' : i===current ? 'bg-primary text-white' : 'bg-base-200 text-neutral/45'" x-text="i+1"></button>
          </template>
        </div>
        <div class="flex items-center gap-3">
          <div class="flex-1">
            <div class="flex justify-between text-[11px] font-bold text-neutral/55 mb-1">
              <span x-text="'Phần '+(current+1)+'/'+sections.length+' · '+sections[current].title"></span>
              <span x-show="!submitted">⏱ còn ~<span x-text="timeLeft"></span> phút</span>
            </div>
            <div class="h-2 rounded-full bg-base-200 overflow-hidden">
              <div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary transition-all duration-300" :style="`width:${progress}%`"></div>
            </div>
          </div>
          <div class="scorepill shrink-0 inline-flex items-center gap-1.5 rounded-full border border-primary/25 bg-primary/8 px-3 py-1.5 text-primary font-bold text-sm">
            <span class="ico w-4 h-4" x-html="icon('bolt')"></span><span x-text="overall"></span>
          </div>
        </div>
      </div>

      <form x-on:submit.prevent class="rounded-3xl border border-base-300 bg-base-100 p-5 sm:p-7 shadow-sm">
        <template x-for="(sec,si) in sections" :key="si">
          <div x-show="current===si" x-transition.opacity :data-screen-label="'Phần '+(si+1)">
            <!-- section head -->
            <div class="flex items-start gap-3 pb-5 mb-6 border-b border-base-300">
              <span class="ico w-11 h-11 shrink-0 rounded-xl bg-primary/8 text-primary p-2.5" x-html="icon(sec.icon)"></span>
              <div>
                <h3 class="font-display font-bold text-xl sm:text-2xl tracking-tight text-neutral"><span x-text="(si+1)+'. '"></span><span x-text="sec.title"></span></h3>
                <p class="text-sm text-neutral/55 mt-0.5" x-text="sec.desc"></p>
              </div>
            </div>

            <!-- SUMMARY step -->
            <template x-if="sec.summary">
              <div>
                <div class="grid sm:grid-cols-2 gap-3">
                  <template x-for="(b,i) in [
                    ['review','Báo cáo chi tiết','Phân tích chuyên sâu từng lĩnh vực.'],
                    ['spark','Đề xuất AI tối ưu','Giải pháp phù hợp thực tế DN.'],
                    ['map','Lộ trình triển khai','Kế hoạch 30·90·180 ngày.'],
                    ['hr','Tư vấn 1:1','Đồng hành cùng chuyển đổi số.']
                  ]" :key="i">
                    <div class="flex items-start gap-3 rounded-2xl border border-base-300 bg-base-200/50 p-4">
                      <span class="ico w-8 h-8 shrink-0 rounded-lg bg-primary/10 text-primary p-1.5" x-html="icon(b[0])"></span>
                      <div><div class="font-bold text-neutral text-sm" x-text="b[1]"></div><div class="text-xs text-neutral/55 mt-0.5" x-text="b[2]"></div></div>
                    </div>
                  </template>
                </div>
                <div class="mt-6 rounded-2xl bg-gradient-to-br from-primary to-secondary p-6 text-center text-white">
                  <div class="text-sm font-semibold opacity-90">Điểm AI Readiness tạm tính của bạn</div>
                  <div class="font-display font-bold text-6xl my-1" x-text="overall"></div>
                  <div class="text-sm font-semibold opacity-90" x-text="level.name + ' · ' + level.tag"></div>
                </div>
                <button type="button" x-on:click="submit()" class="btn btn-primary btn-lg w-full rounded-2xl mt-5 text-base shadow-lg shadow-primary/30">
                  <span class="ico w-5 h-5" x-html="icon('send')"></span> Xem báo cáo của tôi
                </button>
                <p class="text-center text-sm text-neutral/50 mt-3">Báo cáo chi tiết sẽ được gửi trong 1–3 ngày làm việc.</p>
              </div>
            </template>

            <!-- QUESTIONS -->
            <template x-if="!sec.summary">
              <div class="space-y-7">
                <div class="grid md:grid-cols-2 gap-x-6 gap-y-7">
                  <template x-for="(f,fi) in sec._fields" :key="fi">
                    <div :class="f.half ? '' : 'md:col-span-2'">
                      <label class="block text-sm font-bold text-neutral mb-2">
                        <span x-text="f.q.q"></span><span x-show="f.q.req" class="text-error"> *</span>
                      </label>

                      <template x-if="f.q.t==='text'">
                        <input type="text" class="input input-bordered w-full" :placeholder="f.q.ph" x-model="answers[f.q._k]">
                      </template>
                      <template x-if="f.q.t==='textarea'">
                        <textarea class="textarea textarea-bordered w-full min-h-24" :placeholder="f.q.ph" x-model="answers[f.q._k]"></textarea>
                      </template>
                      <template x-if="f.q.t==='select'">
                        <select class="select select-bordered w-full" x-model="answers[f.q._k]">
                          <option value="" disabled x-text="f.q.ph"></option>
                          <template x-for="(o,oi) in f.q.opts" :key="oi"><option x-text="o"></option></template>
                        </select>
                      </template>
                      <template x-if="f.q.t==='single'">
                        <div class="grid gap-2.5" :class="gridCls(f.q.cols)">
                          <template x-for="(o,oi) in f.q.opts" :key="oi">
                            <div class="opt rd" :class="isPick(f.q._k,oi) && 'on'" x-on:click="pick(f.q._k,oi)">
                              <span class="tick" x-html="icon('check')"></span><span x-text="o[0]"></span>
                            </div>
                          </template>
                        </div>
                      </template>
                      <template x-if="f.q.t==='multi'">
                        <div class="grid gap-2.5" :class="gridCls(f.q.cols)">
                          <template x-for="(o,oi) in f.q.opts" :key="oi">
                            <div class="opt" :class="inMulti(f.q._k,oi) && 'on'" x-on:click="toggleMulti(f.q._k,oi)">
                              <span class="tick" x-html="icon('check')"></span><span x-text="o[0]"></span>
                            </div>
                          </template>
                        </div>
                      </template>
                      <template x-if="f.q.t==='toggle'">
                        <div class="grid gap-2.5" :class="gridCls(f.q.cols)">
                          <template x-for="(o,oi) in f.q.opts" :key="oi">
                            <div class="opt justify-between" :class="inMulti(f.q._k,oi) && 'on'" x-on:click="toggleMulti(f.q._k,oi)">
                              <span class="font-semibold" x-text="o[0]"></span><span class="tick" x-html="icon('check')"></span>
                            </div>
                          </template>
                        </div>
                      </template>
                      <template x-if="f.q.t==='rating'">
                        <div class="grid grid-cols-5 gap-2">
                          <template x-for="(o,oi) in f.q.opts" :key="oi">
                            <div class="rate" :class="isPick(f.q._k,oi) && 'on'" x-on:click="pick(f.q._k,oi)">
                              <span class="n" x-text="oi+1"></span>
                              <span class="text-[11px] font-semibold text-neutral/55 leading-tight" x-text="o[0]"></span>
                            </div>
                          </template>
                        </div>
                      </template>
                      <template x-if="f.q.t==='emoji'">
                        <div class="grid grid-cols-5 gap-2">
                          <template x-for="(o,oi) in f.q.opts" :key="oi">
                            <div class="rate" :class="isPick(f.q._k,oi) && 'on'" x-on:click="pick(f.q._k,oi)">
                              <span class="text-2xl leading-none" x-text="o[0]"></span>
                              <span class="text-[11px] font-semibold text-neutral/55 leading-tight" x-text="o[1]"></span>
                            </div>
                          </template>
                        </div>
                      </template>
                    </div>
                  </template>
                </div>
                <!-- cheer -->
                <div x-show="sec.cheer" class="flex items-center gap-2.5 rounded-xl bg-success/8 border border-success/20 px-4 py-3 text-sm font-semibold text-success">
                  <span class="ico w-5 h-5 shrink-0" x-html="icon('spark')"></span><span x-text="sec.cheer"></span>
                </div>
              </div>
            </template>
          </div>
        </template>

        <!-- nav -->
        <div class="no-print mt-8 pt-5 border-t border-base-300 flex items-center justify-between gap-3">
          <button type="button" x-on:click="prev()" class="btn btn-ghost rounded-full" :class="current===0 && 'invisible'">← Quay lại</button>
          <button type="button" x-on:click="saveDraft()" class="btn btn-ghost btn-sm rounded-full text-neutral/60 hidden sm:inline-flex">💾 Lưu nháp</button>
          <button type="button" x-on:click="next()" x-show="current < sections.length-1" class="btn btn-primary rounded-full px-7 shadow-md shadow-primary/30">Tiếp tục →</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- ===== RESULT ===== -->
<section id="result" x-show="submitted" x-cloak class="bg-base-200/60 border-y border-base-300">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
    <div class="max-w-2xl">
      <span class="text-sm font-bold tracking-wide text-primary">KẾT QUẢ</span>
      <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">Báo cáo AI Readiness</h2>
    </div>
    <div class="mt-8 grid lg:grid-cols-12 gap-5">
      <!-- score -->
      <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-7 text-center">
        <div class="radial-progress text-primary font-display mx-auto" :style="`--value:${overall};--size:9rem;--thickness:11px`" role="progressbar">
          <span class="text-4xl font-bold" x-text="overall"></span>
        </div>
        <h3 class="mt-4 font-display font-bold text-2xl text-neutral" x-text="level.name"></h3>
        <div class="mt-1.5 inline-flex flex-wrap justify-center gap-1.5">
          <template x-for="(l,i) in ['Manual','Foundation','AI Ready','Transformation']" :key="i">
            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full" :class="i===level.idx ? 'bg-primary text-white' : 'bg-base-200 text-neutral/40'" x-text="l"></span>
          </template>
        </div>
        <p class="mt-4 text-sm text-neutral/60 leading-relaxed text-left" x-text="level.desc"></p>
        <button x-on:click="printReport()" class="btn btn-outline btn-primary btn-sm rounded-full mt-5 no-print">In / Lưu PDF</button>
      </div>
      <!-- radar -->
      <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-6">
        <h3 class="font-bold text-neutral mb-2">Radar 5 trục</h3>
        <div class="relative h-[260px]"><canvas id="radarChart"></canvas></div>
      </div>
      <!-- bars -->
      <div class="lg:col-span-4 rounded-3xl border border-base-300 bg-base-100 p-6">
        <h3 class="font-bold text-neutral mb-4">Điểm từng nhóm</h3>
        <div class="space-y-4">
          <template x-for="b in bars" :key="b.k">
            <div>
              <div class="flex justify-between text-sm font-semibold text-neutral/70"><span x-text="b.label"></span><span class="font-display" x-text="b.val"></span></div>
              <div class="h-2.5 rounded-full bg-base-200 mt-1.5 overflow-hidden"><div class="h-full rounded-full bg-gradient-to-r from-primary to-secondary" :style="`width:${b.val}%`"></div></div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="mt-5 grid lg:grid-cols-3 gap-5">
      <div class="rounded-3xl border border-base-300 bg-base-100 p-6">
        <h3 class="font-bold text-neutral flex items-center gap-2"><span class="ico w-5 h-5 text-error" x-html="icon('target')"></span> Pain Point Map</h3>
        <ul class="mt-4 space-y-2.5">
          <template x-for="(p,i) in advice.pain" :key="i">
            <li class="flex gap-2.5 text-sm text-neutral/65 leading-relaxed"><span class="text-error font-bold">•</span><span x-text="p"></span></li>
          </template>
        </ul>
      </div>
      <div class="rounded-3xl border border-base-300 bg-base-100 p-6">
        <h3 class="font-bold text-neutral flex items-center gap-2"><span class="ico w-5 h-5 text-secondary" x-html="icon('bolt')"></span> AI Opportunity Map</h3>
        <ul class="mt-4 space-y-2.5">
          <template x-for="(o,i) in advice.opp" :key="i">
            <li class="flex gap-2.5 text-sm text-neutral/65 leading-relaxed"><span class="text-secondary font-bold">•</span><span x-text="o"></span></li>
          </template>
        </ul>
      </div>
      <div class="rounded-3xl border border-base-300 bg-base-100 p-6">
        <h3 class="font-bold text-neutral flex items-center gap-2"><span class="ico w-5 h-5 text-accent" x-html="icon('map')"></span> Lộ trình 30·90·180</h3>
        <ol class="mt-4 relative border-l-2 border-base-300 ml-1 space-y-4">
          <template x-for="(r,i) in roadmap" :key="i">
            <li class="pl-4 relative">
              <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-primary"></span>
              <div class="text-xs font-bold text-primary" x-text="r[0]"></div>
              <div class="text-sm text-neutral/65 mt-0.5 leading-relaxed" x-text="r[1]"></div>
            </li>
          </template>
        </ol>
      </div>
    </div>

    <div class="mt-5 rounded-3xl border border-primary/20 bg-gradient-to-br from-primary/5 to-secondary/5 p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
      <div class="max-w-2xl">
        <h3 class="font-bold text-neutral flex items-center gap-2"><span class="ico w-5 h-5 text-primary" x-html="icon('spark')"></span> Gói tư vấn đề xuất</h3>
        <p class="mt-2 text-sm text-neutral/65 leading-relaxed" x-text="level.pkg"></p>
      </div>
      <div class="flex gap-2 shrink-0 no-print">
        <button x-on:click="redo()" class="btn btn-ghost rounded-full">Làm lại</button>
        <a href="#contact" class="btn btn-primary rounded-full px-6 shadow-md shadow-primary/30">Đặt lịch tư vấn 1:1</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== PRICING ===== -->
<section id="pricing" class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="max-w-2xl">
    <span class="text-sm font-bold tracking-wide text-primary">GÓI DỊCH VỤ</span>
    <h2 class="mt-2 font-display font-bold text-3xl lg:text-4xl tracking-tight text-neutral">Từ đánh giá đến triển khai</h2>
  </div>
  <div class="mt-9 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <template x-for="(p,i) in [
      ['START','primary','AI Workflow Audit','Khảo sát, scoring, báo cáo hiện trạng.','Mới bắt đầu'],
      ['SETUP','success','Digital Workflow Foundation','SOP, CRM, dashboard, dữ liệu cơ bản.','Nền tảng số'],
      ['PILOT','accent','AI Workflow Implementation','Triển khai AI cho 1–2 use case ROI nhanh.','Sẵn sàng AI'],
      ['SCALE','warning','AI Transformation Program','AI OS, Agent, Dashboard, Automation Center.','Scale toàn diện']
    ]" :key="i">
      <div class="rounded-2xl border border-base-300 bg-base-100 p-6 flex flex-col transition hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10">
        <span class="self-start text-[11px] font-bold px-2.5 py-1 rounded-full" :class="`bg-${p[1]}/12 text-${p[1]}`" x-text="p[0]"></span>
        <h3 class="mt-4 font-bold text-lg text-neutral leading-snug" x-text="p[2]"></h3>
        <p class="mt-2 text-sm text-neutral/55 leading-relaxed flex-1" x-text="p[3]"></p>
        <div class="mt-4 pt-4 border-t border-base-300 text-sm font-semibold text-neutral/70">Phù hợp: <span x-text="p[4]"></span></div>
      </div>
    </template>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer id="contact" class="bg-neutral text-neutral-content">
  <div class="mx-auto max-w-7xl px-6 py-12 grid md:grid-cols-4 gap-8 items-start">
    <div>
      <div class="flex items-center gap-2.5">
        <span class="grid place-items-center w-9 h-9 rounded-lg text-white font-display font-bold" style="background:linear-gradient(135deg,#2f6bff,#13b6e6)">T</span>
        <span class="font-bold text-lg">THUCHOCVN</span>
      </div>
      <p class="mt-3 text-sm text-neutral-content/60">Học thật · Làm thật · Giá trị thật</p>
    </div>
    <div class="text-sm"><div class="text-neutral-content/45 font-semibold">Website</div><div class="font-semibold mt-1">thuchocvn.vn</div></div>
    <div class="text-sm"><div class="text-neutral-content/45 font-semibold">Email</div><div class="font-semibold mt-1">admin@thuchocvn.vn</div></div>
    <div class="text-sm"><div class="text-neutral-content/45 font-semibold">Hotline</div><div class="font-semibold mt-1">0397 791 737</div><div class="text-neutral-content/45 mt-1">08:00 – 17:30</div></div>
  </div>
  <div class="border-t border-white/10"><div class="mx-auto max-w-7xl px-6 py-4 text-xs text-neutral-content/40">© 2026 THUCHOCVN · AI for Work &amp; Workforce Development</div></div>
</footer>

<!-- toast -->
<div class="no-print fixed bottom-5 left-1/2 -translate-x-1/2 z-[60]" x-show="toast" x-transition x-cloak>
  <div class="rounded-full bg-neutral text-neutral-content px-5 py-2.5 text-sm font-semibold shadow-xl" x-text="toast"></div>
</div>
</body>
</html>
