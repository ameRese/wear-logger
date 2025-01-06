import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/modules/modal.js',
                'resources/js/modules/search.js',
                'resources/js/modules/calendar.js',
            ],
            refresh: true,
        }),
    ],
});
