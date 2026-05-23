import Alpine from 'alpinejs';

// ── Survey form — implements spec/form.md section 8 ─────────────────────────
// Schema fetched server-side and passed via data-schema attribute (JSON).
// Submit proxied through Laravel to keep the CRM Bearer token server-side.
Alpine.data('surveyForm', () => ({

    // ── State ────────────────────────────────────────────────────────────────
    schema:      null,
    submitUrl:   '',
    currentStep: 0,
    submitted:   false,
    submitting:  false,
    responseId:  null,
    loadError:   null,
    draftSaved:  false,

    // { field_key: value }  — checkbox fields initialised as []
    answers:    {},
    // { field_key: "free text" }  — for is_other options
    otherTexts: {},
    // { field_key: ["error message", ...] }
    errors:     {},

    // ── Computed ─────────────────────────────────────────────────────────────
    get currentSection() {
        return this.schema?.sections?.[this.currentStep] ?? null;
    },
    get totalSteps() {
        return this.schema?.sections?.length ?? 0;
    },
    get progress() {
        if (!this.schema) return 0;
        return ((this.currentStep + 1) / this.totalSteps) * 100;
    },
    get completedSteps() {
        return this.currentStep;
    },

    // ── Init ─────────────────────────────────────────────────────────────────
    init() {
        try {
            this.schema    = JSON.parse(this.$el.dataset.schema || 'null');
            this.submitUrl = this.$el.dataset.submitUrl || '';
            if (this.schema) { this.initAnswers(); this.loadDraft(); }
        } catch {
            this.loadError = 'Không thể tải dữ liệu khảo sát.';
        }
    },

    // Default values: checkbox → [], others → null
    initAnswers() {
        for (const sec of this.schema.sections) {
            for (const field of sec.fields) {
                this.answers[field.field_key] = field.field_type === 6 ? [] : null;
            }
        }
    },

    // ── Navigation ────────────────────────────────────────────────────────────
    nextStep() {
        if (!this.validateSection(this.currentSection)) return;
        this.errors = {};
        if (this.currentStep < this.totalSteps - 1) {
            this.currentStep++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    prevStep() {
        this.errors = {};
        if (this.currentStep > 0) {
            this.currentStep--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    goToStep(i) {
        if (i <= this.currentStep) {
            this.errors     = {};
            this.currentStep = i;
        }
    },

    // ── Client-side validation ────────────────────────────────────────────────
    validateSection(section) {
        if (!section) return true;
        let valid = true;

        for (const field of section.fields) {
            if (!this.isFieldVisible(field)) continue;

            const key = field.field_key;
            const val = this.answers[key];

            // Required
            if (field.is_required) {
                const empty = val === null || val === '' || val === undefined
                    || (Array.isArray(val) && val.length === 0);
                if (empty) {
                    this.errors[key] = ['Trường này là bắt buộc.'];
                    valid = false;
                    continue;
                }
            }

            if (val === null || val === '' || val === undefined) continue;

            // rule_min / rule_max for Text / Textarea (character length)
            if ([1, 2].includes(field.field_type) && typeof val === 'string') {
                if (field.rule_min && val.length < field.rule_min) {
                    this.errors[key] = [`Nhập tối thiểu ${field.rule_min} ký tự.`];
                    valid = false;
                } else if (field.rule_max && val.length > field.rule_max) {
                    this.errors[key] = [`Nhập tối đa ${field.rule_max} ký tự.`];
                    valid = false;
                }
            }

            // rule_min / rule_max for Number / Rating (numeric range)
            if ([3, 7].includes(field.field_type) && typeof val === 'number') {
                if (field.rule_min !== null && val < field.rule_min) {
                    this.errors[key] = [`Giá trị tối thiểu là ${field.rule_min}.`];
                    valid = false;
                } else if (field.rule_max !== null && val > field.rule_max) {
                    this.errors[key] = [`Giá trị tối đa là ${field.rule_max}.`];
                    valid = false;
                }
            }

            // rule_max_select for Checkbox
            if (field.field_type === 6 && field.rule_max_select && Array.isArray(val)
                && val.length > field.rule_max_select) {
                this.errors[key] = [`Chọn tối đa ${field.rule_max_select} mục.`];
                valid = false;
            }
        }

        return valid;
    },

    // ── Submit ────────────────────────────────────────────────────────────────
    async submitForm() {
        this.errors    = {};
        this.loadError = null;

        if (!this.validateSection(this.currentSection)) return;

        this.submitting = true;
        try {
            const r    = await fetch(this.submitUrl, {
                method:  'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'X-CSRF-TOKEN':  document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify(this.buildPayload()),
            });

            const json = await r.json().catch(() => ({}));

            // Success — our proxy wraps CRM response in { success, data, ... }
            if (json.success) {
                this.responseId = json.data?.response_id ?? null;
                this.submitted  = true;
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            // Field validation errors (from CRM 422 or Laravel 422)
            const fieldErrors = json.data?.errors ?? json.errors ?? null;
            if (fieldErrors && Object.keys(fieldErrors).length > 0) {
                this.errors = fieldErrors;
                await this.$nextTick();
                const firstKey = Object.keys(this.errors)[0];
                document.querySelector(`[data-field="${firstKey}"]`)
                    ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            this.loadError = json.data?.message ?? json.message
                ?? 'Có lỗi xảy ra. Vui lòng thử lại.';

        } catch {
            this.loadError = 'Lỗi kết nối. Vui lòng kiểm tra mạng và thử lại.';
        } finally {
            this.submitting = false;
        }
    },

    // Build { respondent_ref, answers[] } — skip empty optional fields
    buildPayload() {
        const answersArr = [];

        for (const [key, val] of Object.entries(this.answers)) {
            if (val === null || val === '' || val === undefined) continue;
            if (Array.isArray(val) && val.length === 0) continue;

            const entry = { field_key: key, value: val };
            if (this.otherTexts[key]) entry.other_text = this.otherTexts[key];
            answersArr.push(entry);
        }

        // respondent_ref: URL ?ref=… or ?email=… or localStorage fallback
        const params        = new URLSearchParams(window.location.search);
        const respondentRef = params.get('ref') || params.get('email')
            || localStorage.getItem('userId') || null;

        return { respondent_ref: respondentRef, answers: answersArr };
    },

    // ── Draft save/load ───────────────────────────────────────────────────────
    saveDraft() {
        if (!this.schema) return;
        try {
            localStorage.setItem(`survey_draft_${this.schema.slug}`, JSON.stringify({
                answers:    this.answers,
                otherTexts: this.otherTexts,
                currentStep: this.currentStep,
            }));
            this.draftSaved = true;
            setTimeout(() => { this.draftSaved = false; }, 2000);
        } catch {}
    },

    loadDraft() {
        if (!this.schema) return;
        try {
            const raw = localStorage.getItem(`survey_draft_${this.schema.slug}`);
            if (!raw) return;
            const draft = JSON.parse(raw);
            if (draft.answers)     this.answers     = { ...this.answers, ...draft.answers };
            if (draft.otherTexts)  this.otherTexts  = draft.otherTexts;
            if (draft.currentStep) this.currentStep = draft.currentStep;
        } catch {}
    },

    // ── Sidebar helpers ───────────────────────────────────────────────────────
    stepStatus(i) {
        if (i < this.currentStep)  return 'done';
        if (i === this.currentStep) return 'active';
        return '';
    },

    sectionColorClass(i) {
        const colors = ['sec-color-0','sec-color-1','sec-color-2','sec-color-3','sec-color-4','sec-color-5','sec-color-6','sec-color-7','sec-color-8'];
        return colors[i] ?? 'sec-color-0';
    },

    sectionBgClass(i) {
        const bgs = ['sec-bg-0','sec-bg-1','sec-bg-2','sec-bg-3','sec-bg-4','sec-bg-5','sec-bg-6','sec-bg-7','sec-bg-8'];
        return bgs[i] ?? 'sec-bg-0';
    },

    // ── Field helpers ─────────────────────────────────────────────────────────

    // parent_field_id: show child only when parent has a value
    isFieldVisible(field) {
        if (!field.parent_field_id) return true;
        for (const sec of this.schema.sections) {
            const parent = sec.fields.find(f => f.id === field.parent_field_id);
            if (!parent) continue;
            const val = this.answers[parent.field_key];
            return val !== null && val !== '' && val !== undefined
                && !(Array.isArray(val) && val.length === 0);
        }
        return true;
    },

    // Checkbox: is option.id in the answers array?
    isChecked(fieldKey, optionId) {
        const arr = this.answers[fieldKey];
        return Array.isArray(arr) && arr.includes(optionId);
    },

    // Checkbox: toggle opt.option_value — respects rule_max_select, handles is_other cleanup
    toggleCheck(field, opt) {
        if (!Array.isArray(this.answers[field.field_key])) {
            this.answers[field.field_key] = [];
        }
        const arr  = this.answers[field.field_key];
        const val  = opt.option_value;
        const idx  = arr.indexOf(val);
        if (idx > -1) {
            arr.splice(idx, 1);
            if (opt.is_other) delete this.otherTexts[field.field_key];
        } else {
            if (field.rule_max_select && arr.length >= field.rule_max_select) return;
            arr.push(val);
        }
        delete this.errors[field.field_key];
    },

    // True when any is_other option is currently checked
    hasOtherSelected(field) {
        const arr = this.answers[field.field_key];
        return Array.isArray(arr)
            && field.options.some(o => o.is_other && arr.includes(o.option_value));
    },

    // Rating: build [rule_min .. rule_max] range array
    ratingRange(field) {
        const min = field.rule_min ?? 1;
        const max = field.rule_max ?? 5;
        return Array.from({ length: max - min + 1 }, (_, i) => min + i);
    },

    ratingLabel(field) {
        const min = field.rule_min ?? 1;
        const max = field.rule_max ?? 5;
        return `${min} = Rất kém  •  ${max} = Rất tốt`;
    },
}));

window.Alpine = Alpine;
Alpine.start();
