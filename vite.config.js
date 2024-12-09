import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/css/input.css', 
                'resources/css/alert.css',
                'resources/css/drawer.css',
                'resources/css/card.css',
                'resources/css/table.css',
                'resources/css/ai.css',
            ],
            refresh: true,
        }),
    ],
});
