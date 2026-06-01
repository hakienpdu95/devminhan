<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default color theme
    |--------------------------------------------------------------------------
    | A DaisyUI `data-theme` value. Must be compiled into the CSS bundle —
    | either a custom brand theme (resources/css/app.css) or a built-in theme
    | enabled in the `@plugin "daisyui"` themes list.
    */
    'default' => env('THEME_DEFAULT', 'brand-light'),

    /*
    |--------------------------------------------------------------------------
    | Cookie name for the runtime theme switcher
    |--------------------------------------------------------------------------
    | When a visitor picks a theme via the switcher, it is persisted here so
    | server-side rendering matches the client (no flash of the wrong theme).
    */
    'cookie' => 'theme',

    /*
    |--------------------------------------------------------------------------
    | Selectable color themes (data-theme values)
    |--------------------------------------------------------------------------
    | Drives the theme switcher and validates per-route/cookie overrides.
    | Keep in sync with resources/css/app.css (custom + enabled built-ins).
    | `scheme` only groups the switcher UI into Light / Dark sections.
    */
    'themes' => [
        // ── Custom brand themes ──────────────────────────────
        'brand-light' => ['label' => 'Brand Light', 'scheme' => 'light'],
        'brand-dark'  => ['label' => 'Brand Dark',  'scheme' => 'dark'],
        'thuchoc'     => ['label' => 'Thuchoc',     'scheme' => 'light'],

        // ── Built-in (light) ─────────────────────────────────
        'corporate'   => ['label' => 'Corporate',   'scheme' => 'light'],
        'nord'        => ['label' => 'Nord',         'scheme' => 'light'],
        'emerald'     => ['label' => 'Emerald',      'scheme' => 'light'],
        'cupcake'     => ['label' => 'Cupcake',      'scheme' => 'light'],
        'winter'      => ['label' => 'Winter',       'scheme' => 'light'],
        'retro'       => ['label' => 'Retro',        'scheme' => 'light'],

        // ── Built-in (dark) ──────────────────────────────────
        'luxury'      => ['label' => 'Luxury',       'scheme' => 'dark'],
        'dracula'     => ['label' => 'Dracula',      'scheme' => 'dark'],
        'business'    => ['label' => 'Business',     'scheme' => 'dark'],
        'synthwave'   => ['label' => 'Synthwave',    'scheme' => 'dark'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout masters (structure)
    |--------------------------------------------------------------------------
    | A layout is the Blade skeleton (navbar/footer/container shape) and is
    | independent of the color theme. Any layout can render under any theme.
    |
    |   - app     : standard portal — navbar + container + footer
    |   - landing : full-bleed marketing / campaign pages
    |   - minimal : bare centered shell — auth, standalone forms
    |
    | A view picks a layout via `@extends($themeMaster)` (the per-route default
    | resolved by ResolveThemeMiddleware) or explicitly, e.g.
    | `@extends('theme::layouts.landing')`.
    */
    'layouts' => [
        'app'     => 'theme::layouts.app',
        'landing' => 'theme::layouts.landing',
        'minimal' => 'theme::layouts.minimal',
        'blank'   => 'theme::layouts.blank',
    ],

    'default_layout' => 'app',

    /*
    |--------------------------------------------------------------------------
    | Brand / navigation
    |--------------------------------------------------------------------------
    | Fallback primary nav rendered by the navbar partial when no $menu is
    | passed from a controller/aggregator. Each item: ['label' => ..., 'url' => ...].
    */
    'nav' => [
        ['label' => 'Trang chủ', 'url' => '/'],
        ['label' => 'Blog',      'url' => '/blog'],
        ['label' => 'Liên hệ',   'url' => '/contact'],
    ],
];
