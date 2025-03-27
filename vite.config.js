import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-BCxwE___.js", "vendor/twa/uikit/dist/app-CHv-Xk-5.css"],
            refresh: true})]});
