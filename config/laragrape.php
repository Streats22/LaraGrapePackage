<?php

return [
    'blocks_path' => resource_path('views/filament/blocks'),
    'user_blocks_path' => null,
    'views_path' => resource_path('views/vendor/LaraGrape'),
    'migrations_path' => database_path('migrations'),

    'debug' => env('LARAGRAPE_DEBUG', false),

    'portfolio_enabled' => env('LARAGRAPE_PORTFOLIO', false),

    'tech_stack' => [
        'defaults' => ['laravel', 'tailwind', 'alpine'],
        'fallback' => [
            'label' => 'Technology',
            'url' => '#',
            'icon' => '⚙️',
        ],
        'aliases' => [
            'js' => 'javascript',
            'ts' => 'typescript',
        ],
        'techs' => [
            'laravel' => [
                'label' => 'Laravel',
                'url' => 'https://laravel.com',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg',
            ],
            'tailwind' => [
                'label' => 'Tailwind CSS',
                'url' => 'https://tailwindcss.com',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg',
            ],
            'alpine' => [
                'label' => 'Alpine.js',
                'url' => 'https://alpinejs.dev',
                'icon' => 'https://cdn.simpleicons.org/alpinedotjs/8BC0D0',
            ],
            'vue' => [
                'label' => 'Vue.js',
                'url' => 'https://vuejs.org',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg',
            ],
            'react' => [
                'label' => 'React',
                'url' => 'https://react.dev',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg',
            ],
            'nuxt' => [
                'label' => 'Nuxt.js',
                'url' => 'https://nuxt.com',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nuxtjs/nuxtjs-original.svg',
            ],
            'filament' => [
                'label' => 'Filament',
                'url' => 'https://filamentphp.com',
                'icon' => 'https://cdn.simpleicons.org/filament/FFAA00',
            ],
            'livewire' => [
                'label' => 'Livewire',
                'url' => 'https://livewire.laravel.com',
                'icon' => 'https://cdn.simpleicons.org/livewire/FB70A9',
            ],
            'laragrape' => [
                'label' => 'LaraGrape',
                'url' => 'https://github.com/streats22/laragrape',
                'icon' => 'https://cdn.simpleicons.org/laravel/FF2D20',
            ],
            'php' => [
                'label' => 'PHP',
                'url' => 'https://php.net',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg',
            ],
            'javascript' => [
                'label' => 'JavaScript',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg',
            ],
            'typescript' => [
                'label' => 'TypeScript',
                'url' => 'https://www.typescriptlang.org',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/typescript/typescript-original.svg',
            ],
        ],
    ],
];
