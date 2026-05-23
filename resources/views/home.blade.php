@extends($themeMaster)

@section('title', ($schema['title'] ?? 'Khảo sát') . ' — ' . config('app.name'))

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen py-10 px-4">
  <div class="max-w-7xl mx-auto">

    {{-- CRM unavailable fallback --}}
    @if (! $schema)
      <div class="max-w-xl mx-auto mt-16">
        <div class="glass-light rounded-2xl p-8 text-center">
          <div class="text-5xl mb-4">⚠️</div>
          <h2 class="text-xl font-bold text-slate-700 mb-2">Không tải được form khảo sát</h2>
          <p class="text-slate-500">Vui lòng thử lại sau hoặc liên hệ hỗ trợ.</p>
        </div>
      </div>

    @else
    {{-- Alpine.js root — schema & submit URL injected via data-* --}}
    <div x-data="surveyForm"
         data-schema='@json($schema)'
         data-submit-url="{{ $submitUrl }}">

      {{-- Connection / server error banner --}}
      <div x-show="loadError" x-cloak
           class="glass-light rounded-2xl p-4 mb-6 flex items-center gap-3 border border-red-100 bg-red-50/80">
        <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="text-red-700 text-sm font-medium" x-text="loadError"></span>
      </div>

      {{-- Success screen --}}
      <template x-if="submitted">
        <div class="max-w-xl mx-auto mt-16">
          <div class="glass-light rounded-[30px] p-12 text-center">
            <div class="text-7xl mb-6">🎉</div>
            <h2 class="text-2xl font-black text-green-600 mb-3">Cảm ơn bạn đã tham gia!</h2>
            <p class="text-slate-500 mb-2">Khảo sát đã được gửi thành công và sẽ xuất hiện trong CRM Dashboard.</p>
            <p x-show="responseId" class="text-xs text-slate-400">
              Mã phản hồi: #<span x-text="responseId"></span>
            </p>
            <p class="text-slate-400 text-sm mt-6">Nhận báo cáo trong 1 – 3 ngày làm việc</p>
          </div>
        </div>
      </template>

      {{-- Main form --}}
      <template x-if="!submitted && schema">
        <div>

          {{-- Top header: title + progress --}}
          <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
            <div>
              <h1 class="text-3xl lg:text-4xl font-black text-blue-950" x-text="schema.title"></h1>
              <p class="text-slate-500 mt-2 text-sm">Form đa bước — điền đầy đủ để nhận báo cáo AI Readiness.</p>
            </div>
            <div class="min-w-[260px]">
              <div class="flex justify-between text-sm font-black text-blue-950 mb-2">
                <span>TIẾN ĐỘ KHẢO SÁT</span>
                <span x-text="Math.round(progress) + '%'"></span>
              </div>
              <div class="survey-progressbar">
                <div class="survey-progressbar-fill" :style="'width:' + progress + '%'"></div>
              </div>
            </div>
          </div>

          {{-- Shell: sidebar + main --}}
          <div class="survey-shell">

            {{-- ── Sidebar ──────────────────────────────────────────────── --}}
            <aside class="survey-aside sticky top-6 self-start">
              <div class="glass-light rounded-[28px] p-5">
                <div class="text-xs font-black text-blue-950 mb-1 tracking-wider">TIẾN TRÌNH KHẢO SÁT</div>
                <div class="text-xs text-slate-400 mb-4">
                  <span x-text="completedSteps"></span> / <span x-text="totalSteps"></span> phần hoàn thành
                </div>
                <div class="space-y-2">
                  <template x-for="(sec, i) in schema.sections" :key="sec.id">
                    <div class="side-step"
                         :class="stepStatus(i)"
                         @click="goToStep(i)">
                      <span class="status" x-text="i + 1"></span>
                      <span>
                        <b class="block text-xs" x-text="sec.title"></b>
                        <small class="text-slate-400"
                               x-text="i < currentStep ? 'Hoàn thành' : (i === currentStep ? 'Đang thực hiện' : '')">
                        </small>
                      </span>
                    </div>
                  </template>
                </div>
              </div>
            </aside>

            {{-- ── Main form card ───────────────────────────────────────── --}}
            <main class="flex-1 min-w-0">
              <template x-if="currentSection">
                <div class="glass-light rounded-[30px] p-6 lg:p-8">

                  {{-- Section header --}}
                  <div class="mb-7 rounded-2xl border p-5"
                       :class="sectionBgClass(currentStep)">
                    <h2 class="text-2xl font-black"
                        :class="sectionColorClass(currentStep)">
                      <span x-text="(currentStep + 1) + '. ' + currentSection.title.toUpperCase()"></span>
                    </h2>
                    <p class="text-slate-500 mt-1 text-sm" x-show="currentSection.description"
                       x-text="currentSection.description"></p>
                  </div>

                  {{-- Fields --}}
                  <div class="space-y-6">
                    <template x-for="field in currentSection.fields" :key="field.id">
                      <div x-show="isFieldVisible(field)" :data-field="field.field_key">

                        {{-- Label --}}
                        <label class="block mb-2 text-sm font-semibold text-slate-700 leading-snug">
                          <span x-text="field.label"></span>
                          <span x-show="field.is_required" class="text-red-500 ml-0.5">*</span>
                        </label>

                        {{-- field_type 1: Text --}}
                        <template x-if="field.field_type === 1">
                          <input type="text"
                                 class="survey-field"
                                 :class="errors[field.field_key] ? 'error' : ''"
                                 :placeholder="field.placeholder || ''"
                                 x-model="answers[field.field_key]"
                                 @input="delete errors[field.field_key]">
                        </template>

                        {{-- field_type 2: Textarea --}}
                        <template x-if="field.field_type === 2">
                          <textarea class="survey-field min-h-[100px] resize-y"
                                    :class="errors[field.field_key] ? 'error' : ''"
                                    :placeholder="field.placeholder || ''"
                                    x-model="answers[field.field_key]"
                                    @input="delete errors[field.field_key]"></textarea>
                        </template>

                        {{-- field_type 3: Number --}}
                        <template x-if="field.field_type === 3">
                          <input type="number"
                                 class="survey-field"
                                 :class="errors[field.field_key] ? 'error' : ''"
                                 :min="field.rule_min" :max="field.rule_max"
                                 x-model.number="answers[field.field_key]"
                                 @input="delete errors[field.field_key]">
                        </template>

                        {{-- field_type 4: Select dropdown — value = opt.option_value (string) --}}
                        <template x-if="field.field_type === 4">
                          <select class="survey-field"
                                  :class="errors[field.field_key] ? 'error' : ''"
                                  x-model="answers[field.field_key]"
                                  @change="delete errors[field.field_key]">
                            <option :value="null">-- Chọn --</option>
                            <template x-for="opt in field.options" :key="opt.id">
                              <option :value="opt.option_value" x-text="opt.label"></option>
                            </template>
                          </select>
                        </template>

                        {{-- field_type 5: Radio — value = opt.option_value (string) --}}
                        <template x-if="field.field_type === 5">
                          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                            <template x-for="opt in field.options" :key="opt.id">
                              <label class="choice-pill"
                                     :class="answers[field.field_key] === opt.option_value ? 'selected' : ''">
                                <input type="radio"
                                       class="sr-only"
                                       :name="field.field_key"
                                       :checked="answers[field.field_key] === opt.option_value"
                                       @change="answers[field.field_key] = opt.option_value; delete errors[field.field_key]">
                                <span class="text-sm" x-text="opt.label"></span>
                              </label>
                            </template>
                          </div>
                        </template>

                        {{-- field_type 6: Checkbox — value = opt.option_value[] (string[]) --}}
                        <template x-if="field.field_type === 6">
                          <div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                              <template x-for="opt in field.options" :key="opt.id">
                                <label class="choice-pill"
                                       :class="isChecked(field.field_key, opt.option_value) ? 'selected' : ''">
                                  <input type="checkbox"
                                         class="sr-only"
                                         :checked="isChecked(field.field_key, opt.option_value)"
                                         @change="toggleCheck(field, opt)">
                                  <span class="text-sm" x-text="opt.label"></span>
                                </label>
                              </template>
                            </div>
                            <div x-show="hasOtherSelected(field)" x-cloak class="mt-2">
                              <input type="text"
                                     class="survey-field text-sm"
                                     placeholder="Vui lòng mô tả thêm..."
                                     x-model="otherTexts[field.field_key]">
                            </div>
                            <p x-show="field.rule_max_select"
                               class="text-xs text-slate-400 mt-1">
                              Chọn tối đa <span x-text="field.rule_max_select"></span> mục
                            </p>
                          </div>
                        </template>

                        {{-- field_type 7: Rating --}}
                        <template x-if="field.field_type === 7">
                          <div>
                            <div class="flex gap-2 flex-wrap">
                              <template x-for="n in ratingRange(field)" :key="n">
                                <div class="rating-opt"
                                     :class="answers[field.field_key] === n ? 'selected' : ''"
                                     @click="answers[field.field_key] = n; delete errors[field.field_key]">
                                  <b x-text="n"></b>
                                </div>
                              </template>
                            </div>
                            <p class="text-xs text-slate-400 mt-1" x-text="ratingLabel(field)"></p>
                          </div>
                        </template>

                        {{-- field_type 8: Date --}}
                        <template x-if="field.field_type === 8">
                          <input type="date"
                                 class="survey-field"
                                 :class="errors[field.field_key] ? 'error' : ''"
                                 x-model="answers[field.field_key]"
                                 @change="delete errors[field.field_key]">
                        </template>

                        {{-- field_type 9: Boolean --}}
                        <template x-if="field.field_type === 9">
                          <div class="flex gap-3">
                            <label class="choice-pill"
                                   :class="answers[field.field_key] === true ? 'selected' : ''">
                              <input type="radio" class="sr-only" :name="field.field_key"
                                     :checked="answers[field.field_key] === true"
                                     @change="answers[field.field_key] = true; delete errors[field.field_key]">
                              <span class="text-sm font-medium">Có</span>
                            </label>
                            <label class="choice-pill"
                                   :class="answers[field.field_key] === false ? 'selected' : ''">
                              <input type="radio" class="sr-only" :name="field.field_key"
                                     :checked="answers[field.field_key] === false"
                                     @change="answers[field.field_key] = false; delete errors[field.field_key]">
                              <span class="text-sm font-medium">Không</span>
                            </label>
                          </div>
                        </template>

                        {{-- Per-field error --}}
                        <p x-show="errors[field.field_key]"
                           x-cloak
                           class="text-red-500 text-xs mt-1.5"
                           x-text="errors[field.field_key]?.[0]"></p>

                      </div>{{-- /field --}}
                    </template>
                  </div>{{-- /fields --}}

                  {{-- Last section: benefit cards + big submit --}}
                  <template x-if="currentStep === totalSteps - 1">
                    <div class="mt-8">
                      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="mini-card">
                          <b class="text-sm">📋 Báo cáo chi tiết</b>
                          <p class="text-xs text-slate-500 mt-2">Phân tích chuyên sâu lĩnh vực DN.</p>
                        </div>
                        <div class="mini-card">
                          <b class="text-sm">⭐ Đề xuất AI tối ưu</b>
                          <p class="text-xs text-slate-500 mt-2">Giải pháp phù hợp thực tế.</p>
                        </div>
                        <div class="mini-card">
                          <b class="text-sm">🗺️ Lộ trình triển khai</b>
                          <p class="text-xs text-slate-500 mt-2">Kế hoạch cụ thể, dễ hiểu.</p>
                        </div>
                        <div class="mini-card">
                          <b class="text-sm">👥 Tư vấn 1:1</b>
                          <p class="text-xs text-slate-500 mt-2">Đồng hành chuyển đổi số.</p>
                        </div>
                      </div>
                    </div>
                  </template>

                  {{-- Navigation --}}
                  <div class="flex justify-between items-center mt-8 pt-6 border-t border-blue-100">

                    {{-- Back --}}
                    <button type="button"
                            class="survey-btn-ghost rounded-2xl px-6 py-3"
                            :style="currentStep > 0 ? '' : 'visibility:hidden'"
                            @click="prevStep()">
                      ← Quay lại
                    </button>

                    {{-- Save draft --}}
                    <button type="button"
                            class="survey-btn-ghost rounded-2xl px-6 py-3"
                            @click="saveDraft()">
                      <span x-text="draftSaved ? '✅ Đã lưu' : '💾 Lưu dự thảo'"></span>
                    </button>

                    {{-- Next --}}
                    <button type="button"
                            class="survey-btn-primary rounded-2xl px-7 py-3"
                            x-show="currentStep < totalSteps - 1"
                            @click="nextStep()">
                      Tiếp theo →
                    </button>

                    {{-- Submit --}}
                    <button type="button"
                            class="survey-btn-primary rounded-2xl py-4 px-8 text-lg w-full mt-2"
                            x-show="currentStep === totalSteps - 1"
                            :disabled="submitting"
                            @click="submitForm()"
                            style="display:none">
                      <span x-show="submitting" x-cloak
                            class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                      <span x-text="submitting ? 'Đang gửi...' : '🚀 GỬI KHẢO SÁT HOÀN TẤT'"></span>
                    </button>

                  </div>

                </div>{{-- /glass card --}}
              </template>{{-- /currentSection --}}
            </main>

          </div>{{-- /survey-shell --}}

        </div>
      </template>{{-- /form --}}

    </div>{{-- /x-data --}}
    @endif

  </div>
</div>
@endsection
