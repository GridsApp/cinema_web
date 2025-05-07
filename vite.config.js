import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-CtC0RKbr.js", "vendor/twa/uikit/dist/app-CHaSB4WH.css"],
            refresh: true})]});
