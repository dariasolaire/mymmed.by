import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject";
import { copy } from 'fs-extra';
import path from 'path';

export default defineConfig({
    plugins: [
        inject({
            Cookies: 'cookies-js',
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        {
            apply: 'build',
            name: 'copy-sources',
            writeBundle() {
                copy(path.join('resources', 'css'), 'public/sources/css');
                copy(path.join('resources', 'js'), 'public/sources/js');
            },
        },

    ]
});
