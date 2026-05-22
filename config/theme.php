<?php

return [
    'default' => env('THEME_DEFAULT', 'default'),

    'available' => [
        'default' => [
            'name' => 'Default',
            'master' => 'theme::themes.default.layouts.master',
        ],
        'modern' => [
            'name' => 'Modern',
            'master' => 'theme::themes.modern.layouts.master',
        ],
        'luxury' => [
            'name' => 'Luxury',
            'master' => 'theme::themes.luxury.layouts.master',
        ],
    ],
];
