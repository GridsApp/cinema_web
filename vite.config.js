import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-C7sgY6aZ.js", "vendor/twa/uikit/dist/app-DDp6jU5g.css"],
            refresh: true})]});
