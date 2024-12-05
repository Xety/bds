import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/bds.css',
                'resources/js/bds.js',
                'resources/js/calendars.js',
                'resources/js/apexcharts.js',
                'resources/js/chart.js'
            ],
            refresh: true,
        })
    ],
    build: {
        chunkSizeWarningLimit: 1000
    }
});
