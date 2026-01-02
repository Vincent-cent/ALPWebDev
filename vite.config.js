import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/admin/promocode-form.js',
                'resources/js/admin/banner-form.js',
                'resources/js/admin/payment-method-form.js',
                'resources/js/user/transaction-history.js'
            ],
            refresh: true,
        }),
    ],
});
