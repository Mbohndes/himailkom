import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // 🛠️ TAMBAHKAN BLOK KODE DI BAWAH INI:
    server: {
        host: true,
        hmr: {
            host: '10.3.1.172'
        }
    },
});
