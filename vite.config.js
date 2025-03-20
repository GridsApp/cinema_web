import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-BWi0WNwC.js", "vendor/twa/uikit/dist/app-D-qQ4Quj.css"],
            refresh: true})]});
