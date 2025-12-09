import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

function getAllCssFiles(dir) {
    let files = [];
    const items = fs.readdirSync(dir, { withFileTypes: true });
    
    for (const item of items) {
        const fullPath = path.join(dir, item.name);
        if (item.isDirectory()) {
            files = files.concat(getAllCssFiles(fullPath));
        } else if (item.isFile() && item.name.endsWith('.css')) {
            files.push(path.relative(process.cwd(), fullPath).replace(/\\/g, '/'));
        }
    }
    return files;
}

const cssFiles = getAllCssFiles('resources/css');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
