import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/bds.css',
                'resources/css/leaflet.css',
                'resources/js/bds.js',
                'resources/js/calendars.js',
                'resources/js/apexcharts.js',
                'resources/js/chart.js',
                'resources/js/leaflet.js'
            ],
            refresh: true,
        })
    ],
    build: {
        chunkSizeWarningLimit: 1000
    }
});
