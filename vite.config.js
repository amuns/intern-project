import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/header.css',
                'resources/css/footer.css',
                'resources/css/theme.css',
                'resources/js/app.js',
                'resources/sass/style.scss',
                // 'resources/fonts/Galano-Grotesque.otf'
            ],
            refresh: true,
        }),
    ],
});
