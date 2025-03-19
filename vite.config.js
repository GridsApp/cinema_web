import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-lynQysIv.js", "vendor/twa/uikit/dist/app-ez332ZJB.css"],
            refresh: true})]});
