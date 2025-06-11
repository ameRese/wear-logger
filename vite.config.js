import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/modules/calendar.js',
                'resources/js/modules/http-request.js',
                'resources/js/modules/image-preview.js',
                'resources/js/modules/modal.js',
                'resources/js/modules/multi-select.js',
                'resources/js/modules/search.js',
                'resources/js/modules/toast.js',
            ],
            refresh: true,
        }),
    ],
});
