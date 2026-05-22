<?php

namespace Modules\Theme\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ResolveThemeAction
{
    use AsAction;

    /**
     * Resolve theme name for the current request.
     *
     * Priority: per-page config → query param (dev only) → route default → global default.
     */
    public function handle(Request $request, ?string $pageTheme = null): string
    {
        if ($pageTheme && $this->isAvailable($pageTheme)) {
            return $pageTheme;
        }

        // Allow ?theme=xxx in local/dev for quick preview
        if (app()->isLocal() && $request->query('theme')) {
            $queryTheme = $request->query('theme');
            if ($this->isAvailable($queryTheme)) {
                return $queryTheme;
            }
        }

        return config('theme.default', 'default');
    }

    public function masterLayout(string $theme): string
    {
        return config("theme.available.{$theme}.master", 'theme::themes.default.layouts.master');
    }

    private function isAvailable(string $theme): bool
    {
        return array_key_exists($theme, config('theme.available', []));
    }
}
