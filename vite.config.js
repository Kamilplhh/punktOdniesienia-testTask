import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/index.css',
                'resources/css/register.css',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/admin.js',
                'resources/js/settings.js',
                'resources/js/register.js',
                'resources/js/download.js',
                'resources/js/contractor.js',
                'resources/js/color-modes.js',
            ],
            refresh: true,
        }),
    ],
});
