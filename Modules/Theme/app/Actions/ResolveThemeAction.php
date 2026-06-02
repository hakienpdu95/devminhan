<?php

namespace Modules\Theme\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

/**
 * Resolves the active color theme + layout master for a request.
 *
 * Theme (colors) and layout (structure) are independent axes:
 *   - theme  → a DaisyUI `data-theme` value (config/theme.php → themes)
 *   - layout → a Blade master view path     (config/theme.php → layouts)
 */
class ResolveThemeAction
{
    use AsAction;

    /**
     * Resolve the color theme for the current request.
     *
     * Priority: per-route param → user cookie (switcher) → ?theme= (local) → default.
     */
    public function handle(Request $request, ?string $pageTheme = null): string
    {
        if ($pageTheme && $this->isAvailable($pageTheme)) {
            return $pageTheme;
        }

        // Visitor's runtime choice, persisted by the theme switcher.
        $cookie = $request->cookie(config('theme.cookie', 'theme'));
        if (is_string($cookie) && $this->isAvailable($cookie)) {
            return $cookie;
        }

        // Quick preview in local/dev: /?theme=luxury
        if (app()->isLocal() && ($query = $request->query('theme')) && $this->isAvailable($query)) {
            return $query;
        }

        return config('theme.default', 'brand-light');
    }

    /**
     * Resolve the layout master view path.
     */
    public function layoutMaster(?string $layout = null): string
    {
        $layout = $layout ?: config('theme.default_layout', 'app');

        return config("theme.layouts.{$layout}", 'theme::layouts.app');
    }

    /**
     * Selectable themes, used by the switcher.
     *
     * @return array<string, array{label: string, scheme: string}>
     */
    public function themes(): array
    {
        return config('theme.themes', []);
    }

    public function isForced(string $theme): bool
    {
        return $this->isAvailable($theme);
    }

    private function isAvailable(string $theme): bool
    {
        return array_key_exists($theme, config('theme.themes', []));
    }
}
