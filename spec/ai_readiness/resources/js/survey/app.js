/* ===========================================================
   THUCHOCVN · AI Readiness — Alpine component (ES module)
   =========================================================== */
import Chart from 'chart.js/auto';
import { SURVEY, SURVEY_WEIGHTS, DOMAIN_LABELS } from './data.js';


/* ---- line icons (stroke = currentColor) ---- */
const ICONS = {
  building: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="11" height="18" rx="1.5"/><path d="M15 8h4a1.5 1.5 0 0 1 1.5 1.5V21"/><path d="M8 7h3M8 11h3M8 15h3"/></svg>',
  workflow: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="6" height="5" rx="1.2"/><rect x="15" y="4" width="6" height="5" rx="1.2"/><rect x="9" y="15" width="6" height="5" rx="1.2"/><path d="M6 9v2.5a1.5 1.5 0 0 0 1.5 1.5H11M18 9v2.5a1.5 1.5 0 0 1-1.5 1.5H13"/><path d="M12 13v2"/></svg>',
  sales: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18"/><path d="M4 16l5-5 4 4 7-7"/><path d="M20 8V4h-4"/></svg>',
  hr: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0"/><path d="M16 5.6a3 3 0 0 1 0 4.8"/><path d="M17.5 14.4a5.5 5.5 0 0 1 3 5.1"/></svg>',
  data: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5.5" rx="7" ry="3"/><path d="M5 5.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/><path d="M5 11.5v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/></svg>',
  ai: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="6" width="12" height="12" rx="2.5"/><rect x="9.5" y="9.5" width="5" height="5" rx="1"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/></svg>',
  review: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3.5h6v1"/><path d="M8.5 13l2 2 4-4"/></svg>',
  info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 7.6v.4"/></svg>',
  send: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 3L3 10.5l7 2.6 2.6 7L21 3z"/><path d="M10 13.1L21 3"/></svg>',
  clock: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
  shield: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 7.9-7 9-4-1.1-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>',
  spark: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/></svg>',
  bolt: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L5 13h6l-1 9 8-11h-6l1-9z"/></svg>',
  map: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3L3 5.5v15L9 18l6 2.5 6-2.5v-15L15 5.5 9 3z"/><path d="M9 3v15M15 5.5v15"/></svg>',
  target: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="0.7" fill="currentColor"/></svg>',
  check: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>'
};

/* ---- scoring ---- */
const SC_CLAMP = n => Math.max(0, Math.min(100, Math.round(n)));
function _addOpt(base, opt) { if (opt && opt[1] && base[opt[1]] != null) base[opt[1]] += (opt[2] || 0); }
function _scoreQ(base, q, answers) {
  const v = answers[q._k];
  if (q.t === 'single' || q.t === 'rating' || q.t === 'emoji') {
    if (typeof v === 'number' && q.opts && q.opts[v]) _addOpt(base, q.opts[v]);
  } else if (q.t === 'multi' || q.t === 'toggle') {
    (v || []).forEach(i => { if (q.opts[i]) _addOpt(base, q.opts[i]); });
  }
}
function computeScores(answers) {
  const base = { workflow: 50, sales: 50, hr: 50, data: 50, ai: 50 };
  SURVEY.forEach(sec => sec.qs.forEach(q => {
    if (q.t === 'grid2') q.qs.forEach(sq => _scoreQ(base, sq, answers));
    else _scoreQ(base, q, answers);
  }));
  Object.keys(base).forEach(k => base[k] = SC_CLAMP(base[k]));
  return base;
}
function overallOf(s) {
  const w = SURVEY_WEIGHTS;
  return SC_CLAMP(s.workflow * w.workflow + s.sales * w.sales + s.hr * w.hr + s.data * w.data + s.ai * w.ai);
}

/* ---- result narrative ---- */
const LEVELS = [
  { max: 30, name: "Manual Operation", tag: "Vận hành thủ công",
    desc: "Doanh nghiệp còn vận hành thủ công, dữ liệu và quy trình rời rạc. Chưa nên triển khai AI lớn ngay — hãy chuẩn hoá SOP, checklist và dữ liệu trước.",
    pkg: "Gói START — AI Workflow Audit: khảo sát sâu, vẽ workflow hiện trạng, xây checklist/SOP cơ bản và đề xuất lộ trình 30 ngày." },
  { max: 60, name: "Digital Foundation", tag: "Nền tảng số",
    desc: "Đã có nền tảng số cơ bản nhưng quy trình, dữ liệu và dashboard chưa đồng bộ. Phù hợp triển khai CRM, dashboard và automation nhỏ.",
    pkg: "Gói SETUP — Digital Workflow Foundation: chuẩn hoá SOP, CRM, dữ liệu khách hàng, dashboard quản lý và đào tạo AI cơ bản." },
  { max: 80, name: "AI Ready", tag: "Sẵn sàng AI",
    desc: "Có thể triển khai AI Workflow vào các use case cụ thể: sales follow-up, CSKH, báo cáo CEO, nhập liệu và phân tích dữ liệu.",
    pkg: "Gói PILOT — AI Workflow Implementation: chọn 1–2 use case ROI nhanh, triển khai AI workflow, đo hiệu quả và tối ưu." },
  { max: 101, name: "AI Transformation", tag: "Chuyển đổi AI",
    desc: "Nền tảng tốt để scale AI theo phòng ban: AI dashboard, AI agents, workflow engine và AI Operating System.",
    pkg: "Gói SCALE — AI Transformation Program: xây AI Operating Model, AI Agent, Dashboard điều hành, Automation Center và đo ROI toàn hệ thống." }
];
function levelOf(overall) {
  const idx = LEVELS.findIndex(l => overall <= l.max);
  return { ...LEVELS[idx], idx };
}
const ROADMAPS = [
  [["0–30 ngày", "Audit hiện trạng, vẽ workflow, gom dữ liệu về một mối."],
   ["30–90 ngày", "Xây SOP, checklist, phân quyền và dashboard cơ bản."],
   ["90–180 ngày", "Đào tạo AI nền tảng, chọn 1 pilot nhỏ."]],
  [["0–30 ngày", "Chuẩn hoá CRM / SOP và dữ liệu khách hàng."],
   ["30–90 ngày", "Dashboard sales, automation follow-up, hệ thống KPI."],
   ["90–180 ngày", "Pilot AI cho sales / báo cáo CEO."]],
  [["0–30 ngày", "Chọn 1–2 use case AI có ROI nhanh, chuẩn bị dữ liệu."],
   ["30–90 ngày", "Triển khai AI workflow, đo hiệu quả thực tế."],
   ["90–180 ngày", "Tối ưu và mở rộng AI sang phòng ban khác."]],
  [["0–30 ngày", "Thiết kế AI Operating Model & lớp dữ liệu chung."],
   ["30–90 ngày", "Triển khai AI agents, dashboard điều hành realtime."],
   ["90–180 ngày", "Automation Center, đo ROI toàn hệ thống và scale."]]
];
function adviceOf(scores) {
  const pain = [], opp = [];
  if (scores.workflow < 60) pain.push("Workflow chưa rõ, thiếu SOP / dashboard hoặc cơ chế kiểm soát tiến độ.");
  if (scores.sales < 60) pain.push("Sales có nguy cơ thất thoát lead, thiếu CRM / follow-up hoặc chưa đo tỷ lệ chốt.");
  if (scores.hr < 60) pain.push("Nhân sự & đào tạo còn phụ thuộc cá nhân, khó onboarding người mới.");
  if (scores.data < 60) pain.push("Dữ liệu chưa tập trung / sạch, cần phân quyền, backup và dashboard realtime.");
  if (scores.ai < 60) pain.push("Đội ngũ chưa sẵn sàng AI — nên bắt đầu bằng đào tạo và pilot nhỏ.");
  if (!pain.length) pain.push("Nền tảng vận hành khá tốt — nên tập trung scale AI và đo ROI.");
  if (scores.sales >= 55) opp.push("AI hỗ trợ sales follow-up, nhắc lịch chăm sóc, phân loại lead và soạn nội dung tư vấn.");
  if (scores.workflow >= 55) opp.push("Workflow automation cho giao việc, phê duyệt, nhắc hạn và báo cáo tiến độ.");
  if (scores.data >= 55) opp.push("AI dashboard phân tích dữ liệu, cảnh báo bất thường và tạo báo cáo CEO realtime.");
  if (scores.hr >= 55) opp.push("AI training assistant hỗ trợ onboarding, thư viện tri thức và đào tạo nội bộ.");
  if (scores.ai >= 55) opp.push("Triển khai AI pilot cho 1–2 use case có ROI nhanh trước khi mở rộng.");
  if (!opp.length) opp.push("Cơ hội trước mắt: chuẩn hoá SOP, dữ liệu và dashboard trước khi triển khai AI.");
  return { pain, opp };
}

/* ---- Alpine component ---- */
function surveyApp() {
  return {
    sections: SURVEY,
    current: 0,
    answers: {},
    submitted: false,
    chart: null,
    toast: "",
    _toastT: null,
    LS: "thuchoc_air_v2",

    init() {
      // assign stable keys + flatten into render fields
      this.sections.forEach((sec, si) => {
        sec.qs.forEach((q, qi) => {
          if (q.t === 'grid2') q.qs.forEach((sq, sj) => sq._k = si + '_' + qi + '_' + sj);
          else q._k = si + '_' + qi;
        });
        const list = [];
        sec.qs.forEach(q => {
          if (q.t === 'grid2') q.qs.forEach(sq => list.push({ q: sq, half: true }));
          else list.push({ q, half: false });
        });
        sec._fields = list;
      });
      // restore draft
      let restored = false;
      try {
        const raw = localStorage.getItem(this.LS);
        if (raw) {
          const d = JSON.parse(raw);
          if (d.answers) { this.answers = d.answers; restored = true; }
          if (typeof d.current === 'number') this.current = Math.min(d.current, this.sections.length - 1);
        }
      } catch (e) {}
      // defaults for ratings / single defaults (only if not present)
      this.sections.forEach(sec => sec.qs.forEach(q => {
        const seed = qq => {
          if (qq.t === 'rating' && this.answers[qq._k] == null) this.answers[qq._k] = (qq.def != null ? qq.def : 2);
          if (qq.t === 'single' && qq.def != null && this.answers[qq._k] == null) this.answers[qq._k] = qq.def;
        };
        if (q.t === 'grid2') q.qs.forEach(seed); else seed(q);
      }));
      if (restored) this.flash("Đã khôi phục bản nháp của bạn");
      // autosave
      this.$watch('answers', () => this.persist());
      this.$watch('current', () => this.persist());
    },

    icon(n) { return ICONS[n] || ''; },
    gridCls(c) {
      return ({ 1: 'grid-cols-1', 2: 'grid-cols-1 sm:grid-cols-2', 3: 'grid-cols-2 md:grid-cols-3',
        4: 'grid-cols-2 md:grid-cols-4', 5: 'grid-cols-2 sm:grid-cols-3 md:grid-cols-5', 6: 'grid-cols-3 md:grid-cols-6' })[c || 3] || 'grid-cols-2 md:grid-cols-3';
    },
    flash(msg) { this.toast = msg; clearTimeout(this._toastT); this._toastT = setTimeout(() => this.toast = "", 2600); },
    persist() { try { localStorage.setItem(this.LS, JSON.stringify({ answers: this.answers, current: this.current })); } catch (e) {} },
    saveDraft() { this.persist(); this.flash("💾 Đã lưu nháp — bạn có thể quay lại bất cứ lúc nào"); },

    // selection helpers
    pick(k, i) { this.answers[k] = i; },
    isPick(k, i) { return this.answers[k] === i; },
    inMulti(k, i) { return (this.answers[k] || []).includes(i); },
    toggleMulti(k, i) {
      const cur = (this.answers[k] || []).slice();
      const at = cur.indexOf(i);
      if (at > -1) cur.splice(at, 1); else cur.push(i);
      this.answers[k] = cur;
    },

    // progress + live score
    get progress() { return Math.round(((this.current + 1) / this.sections.length) * 100); },
    get timeLeft() { return Math.max(1, (this.sections.length - 1 - this.current) * 2); },
    get scores() { return computeScores(this.answers); },
    get overall() { return overallOf(this.scores); },
    get level() { return levelOf(this.overall); },
    get bars() {
      const L = DOMAIN_LABELS, s = this.scores;
      return Object.keys(L).map(k => ({ k, label: L[k], val: s[k] }));
    },
    get advice() { return adviceOf(this.scores); },
    get roadmap() { return ROADMAPS[this.level.idx]; },

    stepStatus(i) { return i < this.current ? 'done' : i === this.current ? 'active' : 'todo'; },

    next() { if (this.current < this.sections.length - 1) { this.current++; this.toTop(); } },
    prev() { if (this.current > 0) { this.current--; this.toTop(); } },
    goTo(i) { this.current = i; this.toTop(); },
    toTop() {
      this.$nextTick(() => {
        const el = document.getElementById('survey');
        if (el) { const y = el.getBoundingClientRect().top + window.scrollY - 76; window.scrollTo({ top: y, behavior: 'smooth' }); }
      });
    },

    submit() {
      this.submitted = true;
      this.$nextTick(() => {
        this.renderRadar();
        const el = document.getElementById('result');
        if (el) window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 70, behavior: 'smooth' });
      });
    },
    redo() {
      this.submitted = false;
      this.current = 0;
      this.toTop();
    },
    printReport() { window.print(); },

    renderRadar() {
      const ctx = document.getElementById('radarChart');
      if (!ctx || typeof Chart === 'undefined') return;
      if (this.chart) this.chart.destroy();
      const s = this.scores;
      const css = getComputedStyle(document.documentElement);
      const primary = (css.getPropertyValue('--brand') || '#2f6bff').trim();
      this.chart = new Chart(ctx, {
        type: 'radar',
        data: {
          labels: ['Workflow', 'Sales', 'Nhân sự', 'Dữ liệu', 'AI'],
          datasets: [{
            label: 'Điểm', data: [s.workflow, s.sales, s.hr, s.data, s.ai],
            fill: true, backgroundColor: 'rgba(47,107,255,.14)', borderColor: primary,
            borderWidth: 2, pointBackgroundColor: primary, pointRadius: 4
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          scales: { r: { min: 0, max: 100, ticks: { display: false, stepSize: 20 }, grid: { color: 'rgba(20,40,90,.12)' }, angleLines: { color: 'rgba(20,40,90,.12)' }, pointLabels: { color: '#1c2e54', font: { size: 13, weight: '600', family: 'Be Vietnam Pro' } } } },
          plugins: { legend: { display: false } }
        }
      });
    }
  };
}
export { surveyApp };
