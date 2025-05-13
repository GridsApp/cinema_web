import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', "vendor/twa/uikit/dist/app-t7hqmD3O.js", "vendor/twa/uikit/dist/app-Xp1FHksF.css"],
            refresh: true})]});
