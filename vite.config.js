import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/filament/admin/theme.css',
                'resources/css/filament-grapesjs-editor.css',
                'resources/js/app.js',
                'resources/js/grapesjs-editor.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            external: [],
        },
    },
});
