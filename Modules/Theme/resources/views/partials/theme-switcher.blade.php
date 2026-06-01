{{--
    Runtime theme switcher.
    Sets <html data-theme>, persists to localStorage + a cookie so the next
    server render matches. Themes come from the shared $themes (config/theme.php).
--}}
<div
    x-data="themeSwitcher"
    class="dropdown dropdown-end"
>
    <div tabindex="0" role="button" class="btn btn-ghost btn-sm gap-1" aria-label="Đổi giao diện">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828L9 21"/>
        </svg>
        <span class="hidden sm:inline text-xs font-medium" x-text="label"></span>
    </div>

    <div tabindex="0" class="dropdown-content z-50 mt-2 w-60 rounded-box bg-base-100 p-2 shadow-xl border border-base-300">
        <template x-for="(group, scheme) in groups" :key="scheme">
            <div class="mb-1 last:mb-0">
                <div class="px-2 py-1 text-[0.65rem] font-bold uppercase tracking-wider text-base-content/50"
                     x-text="scheme === 'dark' ? 'Tối' : 'Sáng'"></div>
                <template x-for="t in group" :key="t.value">
                    <button type="button"
                            class="flex w-full items-center gap-3 rounded-lg px-2 py-1.5 text-left text-sm hover:bg-base-200"
                            :class="t.value === current ? 'bg-base-200 font-semibold' : ''"
                            @click="apply(t.value)">
                        {{-- Live swatch rendered in the target theme --}}
                        <span class="flex gap-0.5 rounded-md p-1 border border-base-300" :data-theme="t.value">
                            <span class="size-3 rounded-full bg-primary"></span>
                            <span class="size-3 rounded-full bg-secondary"></span>
                            <span class="size-3 rounded-full bg-accent"></span>
                        </span>
                        <span class="flex-1" x-text="t.label"></span>
                        <svg x-show="t.value === current" class="size-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
    window.__themes = @js($themes ?? []);
    window.__themeCookie = @js(config('theme.cookie', 'theme'));
</script>
@endpush
