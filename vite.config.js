import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/admin/dashboard.css',
                'resources/css/admin/',
                'resources/css/navigation.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
