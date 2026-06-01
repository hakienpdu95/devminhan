/*
 * AI Readiness — Alpine component (aiReadiness)
 *
 * Kết hợp:
 *  - icon() helper cho landing sections
 *  - CRM-driven form: schema inject qua data-schema (fetch từ CRM server-side)
 *  - Submit → Laravel proxy → CRM chấm điểm → nhận result trả về
 *  - ECharts radar cho kết quả
 */
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// ECharts lazy: chỉ load khi renderRadar() được gọi (sau khi user submit).
// echarts-radar.js dùng static named imports → Vite tree-shake đúng.
let _echartsPromise = null;
function loadECharts() {
  if (!_echartsPromise) {
    _echartsPromise = import('./echarts-radar.js').then(m => m.echarts);
  }
  return _echartsPromise;
}

/* ─── Line icons ──────────────────────────────────────────────────────── */
const ICONS = {
  building: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="11" height="18" rx="1.5"/><path d="M15 8h4a1.5 1.5 0 0 1 1.5 1.5V21"/><path d="M8 7h3M8 11h3M8 15h3"/></svg>',
  workflow: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="6" height="5" rx="1.2"/><rect x="15" y="4" width="6" height="5" rx="1.2"/><rect x="9" y="15" width="6" height="5" rx="1.2"/><path d="M6 9v2.5a1.5 1.5 0 0 0 1.5 1.5H11M18 9v2.5a1.5 1.5 0 0 1-1.5 1.5H13"/><path d="M12 13v2"/></svg>',
  sales:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18"/><path d="M4 16l5-5 4 4 7-7"/><path d="M20 8V4h-4"/></svg>',
  hr:       '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0"/><path d="M16 5.6a3 3 0 0 1 0 4.8"/><path d="M17.5 14.4a5.5 5.5 0 0 1 3 5.1"/></svg>',
  data:     '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5.5" rx="7" ry="3"/><path d="M5 5.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/><path d="M5 11.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/></svg>',
  ai:       '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="6" width="12" height="12" rx="2.5"/><rect x="9.5" y="9.5" width="5" height="5" rx="1"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/></svg>',
  review:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3.5h6v1"/><path d="M8.5 13l2 2 4-4"/></svg>',
  info:     '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 7.6v.4"/></svg>',
  send:     '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 3L3 10.5l7 2.6 2.6 7L21 3z"/><path d="M10 13.1L21 3"/></svg>',
  clock:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
  shield:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 7.9-7 9-4-1.1-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>',
  spark:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/></svg>',
  bolt:     '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L5 13h6l-1 9 8-11h-6l1-9z"/></svg>',
  map:      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3L3 5.5v15L9 18l6 2.5 6-2.5v-15L15 5.5 9 3z"/><path d="M9 3v15M15 5.5v15"/></svg>',
  target:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="0.7" fill="currentColor"/></svg>',
  check:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>',
};

/* ─── Levels fallback (dùng nếu CRM không trả level) ─────────────────── */
const LEVELS = [
  { max: 30,  name: 'Manual Operation',  tag: 'Vận hành thủ công',
    desc: 'Doanh nghiệp còn vận hành thủ công. Cần chuẩn hoá SOP và dữ liệu trước khi triển khai AI.',
    pkg:  'Gói START — AI Workflow Audit: audit hiện trạng, SOP cơ bản, lộ trình 30 ngày.' },
  { max: 60,  name: 'Digital Foundation', tag: 'Nền tảng số',
    desc: 'Nền tảng số cơ bản nhưng chưa đồng bộ. Phù hợp CRM, dashboard, automation nhỏ.',
    pkg:  'Gói SETUP — Digital Workflow Foundation: SOP, CRM, dashboard, đào tạo AI cơ bản.' },
  { max: 80,  name: 'AI Ready',           tag: 'Sẵn sàng AI',
    desc: 'Có thể triển khai AI vào sales follow-up, CSKH, báo cáo CEO, nhập liệu.',
    pkg:  'Gói PILOT — AI Workflow Implementation: 1–2 use case ROI nhanh, đo hiệu quả.' },
  { max: 101, name: 'AI Transformation',  tag: 'Chuyển đổi AI',
    desc: 'Nền tảng tốt để scale AI: dashboard, agents, workflow engine, AI OS.',
    pkg:  'Gói SCALE — AI Transformation Program: AI Agent, Dashboard điều hành, đo ROI.' },
];
function levelOf(score) {
  const idx = LEVELS.findIndex(l => score <= l.max);
  return { ...LEVELS[Math.max(0, idx)], idx: Math.max(0, idx) };
}

/* ─── Alpine component factory ────────────────────────────────────────── */
export function aiReadiness() {
  return {
    /* ── State ── */
    schema:          null,
    submitUrl:       '',
    currentStep:     0,
    answers:         {},
    errors:          {},
    submitted:       false,
    submitting:      false,
    scoringPending:  false,
    pollAttempt:     0,
    result:          null,
    loadError:       null,
    toast:           '',
    _toastT:         null,
    _chart:          null,
    _resizeHandler:  null,   // named ref → removeEventListener được
    LS:              'air_crm_v1',

    /* ── Init từ data-* attributes (Blade inject schema server-side) ── */
    init() {
      try {
        this.schema    = JSON.parse(this.$el.dataset.schema    || 'null');
        this.submitUrl = this.$el.dataset.submitUrl || '';
        if (this.schema) { this.initAnswers(); this.loadDraft(); }
        else              { this.loadError = 'Không tải được dữ liệu khảo sát từ CRM.'; }
      } catch {
        this.loadError = 'Không tải được dữ liệu khảo sát từ CRM.';
      }
      this.$watch('answers', () => this.persist());
      this.$watch('currentStep', () => this.persist());
    },

    /* ── Init answers từ schema ── */
    initAnswers() {
      for (const sec of (this.schema?.sections || [])) {
        for (const f of (sec.fields || [])) {
          // field_type 6 = checkbox → default []
          this.answers[f.field_key] = f.field_type === 6 ? [] : null;
        }
      }
    },

    /* ── Icons ── */
    icon(n) { return ICONS[n] || ''; },

    /* ── Computed ── */
    get sections()     { return this.schema?.sections || []; },
    get totalSteps()   { return this.sections.length; },
    get currentSection(){ return this.sections[this.currentStep] ?? null; },
    get progress()     { return Math.round(((this.currentStep + 1) / Math.max(this.totalSteps, 1)) * 100); },
    get timeLeft()     { return Math.max(1, (this.totalSteps - this.currentStep - 1) * 2); },

    /* ── Navigation ── */
    stepStatus(i) { return i < this.currentStep ? 'done' : i === this.currentStep ? 'active' : 'todo'; },

    goTo(i) { this.currentStep = i; this.toTop(); },
    prev()  { if (this.currentStep > 0)                        { this.currentStep--; this.toTop(); } },
    next()  {
      if (!this.validateStep()) return;
      this.errors = {};
      if (this.currentStep < this.totalSteps - 1) { this.currentStep++; this.toTop(); }
    },
    toTop() {
      this.$nextTick(() => {
        const el = document.getElementById('survey');
        if (el) window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 76, behavior: 'smooth' });
      });
    },

    /* ── Field visibility (conditional) ── */
    isVisible(field) {
      if (!field.parent_field_id) return true;
      for (const sec of this.sections) {
        const parent = sec.fields?.find(f => f.id === field.parent_field_id);
        if (!parent) continue;
        const v = this.answers[parent.field_key];
        return v !== null && v !== '' && v !== undefined && !(Array.isArray(v) && v.length === 0);
      }
      return true;
    },

    /* ── Answer helpers (CRM field_type 1–9) ── */
    // field_type 5 = radio: value = option_value string
    pick(key, val)  { this.answers[key] = val; delete this.errors[key]; },
    isPick(key, val){ return this.answers[key] === val; },

    // field_type 6 = checkbox: value = option_value[]
    isChecked(key, val) { return (this.answers[key] || []).includes(val); },
    toggleCheck(key, val, maxSelect) {
      const arr = (this.answers[key] || []).slice();
      const at  = arr.indexOf(val);
      if (at > -1) arr.splice(at, 1);
      else {
        if (maxSelect && arr.length >= maxSelect) return;
        arr.push(val);
      }
      this.answers[key] = arr;
      delete this.errors[key];
    },

    // field_type 7 = rating
    ratingRange(field) {
      const min = field.rule_min ?? 1, max = field.rule_max ?? 5;
      return Array.from({ length: max - min + 1 }, (_, i) => min + i);
    },
    ratingLabel(field) {
      return `${field.rule_min ?? 1} = Rất kém  ·  ${field.rule_max ?? 5} = Rất tốt`;
    },

    /* ── Toast (Toastify) ── */
    _toast(msg, type = 'error') {
      const bg = type === 'error'   ? '#ef4444'
               : type === 'warning' ? '#f59e0b'
               :                      '#22c55e';
      Toastify({
        text:        msg,
        duration:    4500,
        close:       true,
        gravity:     'top',
        position:    'right',
        stopOnFocus: true,
        style: { background: bg, borderRadius: '10px', fontWeight: '600', fontSize: '14px', lineHeight: '1.5' },
      }).showToast();
    },

    /* ── Validation ── */
    _isMissing(v) {
      return v === null || v === '' || v === undefined || (Array.isArray(v) && !v.length);
    },

    validateStep() {
      if (!this.currentSection) return true;
      let valid = true;
      for (const f of (this.currentSection.fields || [])) {
        if (!this.isVisible(f) || !f.is_required) continue;
        if (this._isMissing(this.answers[f.field_key])) {
          this.errors[f.field_key] = ['Trường này là bắt buộc.'];
          valid = false;
        }
      }
      if (!valid) this._toast('Vui lòng điền đầy đủ các trường bắt buộc trước khi tiếp tục.');
      return valid;
    },

    // Kiểm tra TẤT CẢ tab — dùng trong submit().
    // Nhảy đến tab đầu tiên còn thiếu và hiển thị lỗi + toast rõ ràng.
    validateAll() {
      for (let i = 0; i < this.sections.length; i++) {
        const sec = this.sections[i];
        const missing = (sec.fields || []).filter(f => this.isVisible(f) && f.is_required && this._isMissing(this.answers[f.field_key]));
        if (!missing.length) continue;

        // Nhảy đến tab lỗi và highlight các field thiếu
        this.currentStep = i;
        this.errors = {};
        missing.forEach(f => { this.errors[f.field_key] = ['Trường này là bắt buộc.']; });
        this.toTop();

        const tabName = sec.title || sec.name || `Bước ${i + 1}`;
        this._toast(`Mục "${tabName}" còn thiếu thông tin bắt buộc.\nVui lòng điền đầy đủ trước khi gửi.`);
        return false;
      }
      return true;
    },

    // Xử lý field errors từ server (422): set errors + nhảy tab + Toastify rõ ràng.
    _handleFieldErrors(fieldErrors) {
      this.errors = fieldErrors;
      const errorKeys = new Set(Object.keys(fieldErrors));

      // Tìm tab đầu tiên có field bị lỗi, nhảy đến đó
      for (let i = 0; i < this.sections.length; i++) {
        const sec = this.sections[i];
        if (!(sec.fields || []).some(f => errorKeys.has(f.field_key))) continue;
        this.currentStep = i;
        this.toTop();
        break;
      }

      // Gom tất cả message lỗi, hiển thị tối đa 3 dòng + "và X lỗi khác"
      const allMsgs = Object.values(fieldErrors)
        .map(e => (Array.isArray(e) ? e[0] : e))
        .filter(Boolean);
      const shown     = allMsgs.slice(0, 3);
      const remaining = allMsgs.length - shown.length;
      const toastText = remaining > 0
        ? shown.join('\n') + `\n... và ${remaining} lỗi khác`
        : shown.join('\n');
      this._toast(toastText);
    },

    /* ── Persist / draft ── */
    persist() {
      try { localStorage.setItem(this.LS, JSON.stringify({ answers: this.answers, step: this.currentStep })); } catch {}
    },
    loadDraft() {
      try {
        const raw = localStorage.getItem(this.LS);
        if (!raw) return;
        const d = JSON.parse(raw);
        if (d.answers) { this.answers = { ...this.answers, ...d.answers }; }
        if (typeof d.step === 'number') this.currentStep = Math.min(d.step, this.totalSteps - 1);
        this.flash('Đã khôi phục bản nháp của bạn');
      } catch {}
    },
    saveDraft() { this.persist(); this.flash('💾 Đã lưu nháp — bạn có thể quay lại bất cứ lúc nào'); },
    flash(msg)  { this.toast = msg; clearTimeout(this._toastT); this._toastT = setTimeout(() => { this.toast = ''; }, 2800); },

    /* ── Submit → CRM → kết quả ── */
    async submit() {
      if (this.submitting || this.submitted) return; // chặn double-submit
      if (!this.validateAll()) return;
      this.submitting = true;
      this.loadError  = null;
      try {
        const r    = await fetch(this.submitUrl, {
          method:  'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          },
          body: JSON.stringify(this.buildPayload()),
        });
        const json = await r.json().catch(() => ({}));

        if (json.success) {
          this.result         = json.data || {};
          this.submitted      = true;
          this.scoringPending = true;
          this.pollAttempt    = 0;

          // CRM đã xác nhận nhận data → xóa localStorage + reset form NGAY LẬP TỨC
          // Không chờ scoring, vì data đã an toàn phía server.
          this._clearDraft();

          this.$nextTick(() => {
            const el = document.getElementById('result');
            if (el) window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 70, behavior: 'smooth' });
          });
          const responseId = json.data?.response_id ?? null;
          if (responseId) this._pollResult(responseId);
          else            this.scoringPending = false;
          return;
        }

        // 422 field errors từ CRM
        const fieldErrors = json.data?.errors ?? json.errors ?? null;
        if (fieldErrors && Object.keys(fieldErrors).length) { this._handleFieldErrors(fieldErrors); return; }

        this.loadError = json.data?.message ?? json.message ?? 'Có lỗi xảy ra. Vui lòng thử lại.';
      } catch {
        this.loadError = 'Lỗi kết nối. Vui lòng kiểm tra mạng và thử lại.';
      } finally {
        this.submitting = false;
      }
    },

    buildPayload() {
      const answersArr = [];
      for (const [key, val] of Object.entries(this.answers)) {
        if (val === null || val === '' || val === undefined) continue;
        if (Array.isArray(val) && !val.length) continue;
        answersArr.push({ field_key: key, value: val });
      }
      const params = new URLSearchParams(window.location.search);
      const ref    = params.get('ref') || params.get('email') || localStorage.getItem('userId') || null;
      return { respondent_ref: ref, answers: answersArr };
    },

    /* ── Poll kết quả chấm điểm từ CRM ── */
    _pollResult(responseId, attempt = 0) {
      const MAX  = 15; // 15 × 4s ≈ 60 giây
      if (attempt >= MAX) {
        this.scoringPending = false; // timeout → hiển thị fallback "gửi qua email"
        return;
      }
      this.pollAttempt = attempt;

      const slug    = this.schema?.slug ?? 'ai-readiness-workflow';
      const baseUrl = this.submitUrl?.replace(/\/submit$/, '/result') ?? `/survey/${slug}/result`;
      const url     = `${baseUrl}?response_id=${responseId}`;

      setTimeout(async () => {
        try {
          const r    = await fetch(url, {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
          });
          const json = await r.json().catch(() => ({}));

          // Có điểm → hiển thị báo cáo
          if (r.ok && json.success && json.data?.overall_score != null) {
            this._applyScores(json.data);
            return;
          }
          // 202 hoặc 200 chưa có điểm → thử lại
          if (r.status === 202 || (r.ok && json.success)) {
            this._pollResult(responseId, attempt + 1);
            return;
          }
          // Lỗi thật (4xx/5xx) → thử lại tối đa 3 lần rồi dừng
          if (attempt < 3) this._pollResult(responseId, attempt + 1);
          else this.scoringPending = false;
        } catch {
          // Lỗi mạng thoáng qua
          if (attempt < 5) this._pollResult(responseId, attempt + 1);
          else this.scoringPending = false;
        }
      }, attempt === 0 ? 3000 : 4000);
    },

    /* Ánh xạ kết quả CRM → format frontend, tắt loading, render chart */
    _applyScores(data) {
      const scores = {};
      for (const ds of (data.domain_scores ?? [])) {
        scores[ds.domain_code] = Math.round(ds.normalized ?? 0);
      }
      this.result = {
        ...this.result,
        overall:         Math.round(data.overall_score ?? 0),
        score:           Math.round(data.overall_score ?? 0),
        scores:          Object.keys(scores).length ? scores : null,
        roadmap:         data.roadmap ?? [],
        recommendations: data.recommendations ?? [],
        pain_points:     data.pain_points ?? [],
        signal_flags:    data.signal_flags ?? {},
        maturity_level:  data.maturity_level ?? null,
      };
      this.scoringPending = false;  // tắt loading → hiển thị báo cáo
      this.$nextTick(() => { if (this.result.scores) this.renderRadar(); });
    },

    /* Xóa localStorage và reset toàn bộ form về trạng thái ban đầu.
     * Chỉ gọi SAU khi CRM đã ghi nhận + trả điểm thành công.
     * Giữ nguyên submitted/result/scoringPending để báo cáo vẫn hiển thị. */
    _clearDraft() {
      // Reset state trước — $watch('currentStep'/'answers') sẽ gọi persist(),
      // nhưng removeItem() ở CUỐI sẽ xóa sạch toàn bộ sau khi tất cả settled.
      this.errors      = {};
      this.currentStep = 0;
      this.pollAttempt = 0;
      this.answers     = {};
      if (this.schema) this.initAnswers();
      // Xóa CUỐI — đảm bảo không còn dữ liệu cũ dù persist() đã chạy
      try { localStorage.removeItem(this.LS); } catch {}
    },

    redo() {
      this.submitted      = false;
      this.scoringPending = false;
      this.pollAttempt    = 0;
      this.result         = null;
      this.loadError      = null;
      this.errors         = {};
      this.currentStep    = 0;
      // Reset answers về default — không phụ thuộc vào _clearDraft() đã chạy trước
      this.answers        = {};
      if (this.schema) this.initAnswers();
      this.toTop();
    },
    printReport() { window.print(); },

    /* ── Result helpers (CRM trả về) ── */
    get resultOverall()  { return this.result?.overall ?? this.result?.score ?? null; },
    get resultScores()   { return this.result?.scores  ?? {}; },
    get resultRoadmap()  { return this.result?.roadmap ?? []; },
    get resultLevel()   {
      // CRM có thể trả { level: { name, tag, desc, pkg, idx } } hoặc chỉ level name
      if (this.result?.level && typeof this.result.level === 'object') return this.result.level;
      if (this.resultOverall !== null) return levelOf(this.resultOverall);
      return null;
    },
    get resultBars() {
      const s = this.resultScores;
      return [
        { k: 'workflow', label: 'Workflow',      val: s.workflow ?? 0 },
        { k: 'sales',    label: 'Sales',          val: s.sales    ?? 0 },
        { k: 'hr',       label: 'Nhân sự',        val: s.hr       ?? 0 },
        { k: 'data',     label: 'Dữ liệu',        val: s.data     ?? 0 },
        { k: 'ai',       label: 'AI Readiness',   val: s.ai       ?? 0 },
      ];
    },
    get hasScores() { return this.resultOverall !== null && Object.keys(this.resultScores).length > 0; },

    /* ── ECharts radar (lazy load) ── */
    async renderRadar() {
      const dom = document.getElementById('radarChart');
      if (!dom) return;
      if (this._chart) this._chart.dispose();

      const echarts = await loadECharts();   // chunk chỉ load ở đây — sau khi submit

      const css     = getComputedStyle(document.documentElement);
      const primary = css.getPropertyValue('--color-primary').trim() || '#2f6bff';
      const ink     = css.getPropertyValue('--color-base-content').trim() || '#14224a';
      const grid    = css.getPropertyValue('--color-base-300').trim() || '#e6eefb';
      const s       = this.resultScores;

      this._chart = echarts.init(dom);
      this._chart.setOption({
        radar: {
          indicator:  [
            { name: 'Workflow', max: 100 }, { name: 'Sales',    max: 100 },
            { name: 'Nhân sự', max: 100 }, { name: 'Dữ liệu', max: 100 }, { name: 'AI', max: 100 },
          ],
          shape: 'polygon', splitNumber: 4,
          axisName:  { color: ink,  fontSize: 13, fontWeight: 600, fontFamily: 'Be Vietnam Pro' },
          splitLine: { lineStyle: { color: grid } },
          splitArea: { show: false },
          axisLine:  { lineStyle: { color: grid } },
        },
        series: [{ type: 'radar', data: [{
          value: [s.workflow || 0, s.sales || 0, s.hr || 0, s.data || 0, s.ai || 0],
          name: 'Điểm',
          areaStyle: { color: primary + '26' },
          lineStyle: { color: primary, width: 2 },
          itemStyle: { color: primary },
          symbol: 'circle', symbolSize: 6,
        }] }],
        tooltip: { show: true },
      });
      // Named handler → removeEventListener được khi render lại
      if (this._resizeHandler) window.removeEventListener('resize', this._resizeHandler);
      this._resizeHandler = () => this._chart?.resize();
      window.addEventListener('resize', this._resizeHandler, { passive: true });
    },
  };
}
