<?php

return [
    'name' => env('GSMUI_NAME', 'GsmUi'),
    'tagline' => env('GSMUI_TAGLINE', 'The complete Laravel UI ecosystem'),
    'url' => env('GSMUI_URL', 'https://gsmui.dev'),
    'company' => [
        'name' => env('GSMUI_COMPANY_NAME', 'GsmUi'),
        'email' => env('GSMUI_COMPANY_EMAIL', 'hello@gsmui.dev'),
    ],
    'social' => [
        'github' => env('GSMUI_GITHUB', 'https://github.com/gsmui'),
        'twitter' => env('GSMUI_TWITTER', 'https://twitter.com/gsmui'),
        'discord' => env('GSMUI_DISCORD', 'https://discord.gg/gsmui'),
    ],
    'features' => [
        'marketplace' => true,
        'blog' => true,
        'showcase' => true,
        'playground' => true,
        'theme_builder' => true,
    ],
    'seo' => [
        'title_separator' => ' | ',
        'default_title' => 'GsmUi - The complete Laravel UI ecosystem',
        'default_description' => 'Modern UI components, templates, documentation, and tools for Laravel developers.',
    ],
];
