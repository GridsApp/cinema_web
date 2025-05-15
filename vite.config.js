import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-DSGB8meh.js", "vendor/twa/uikit/dist/app-d18U7yhb.css"],
            refresh: true})]});
