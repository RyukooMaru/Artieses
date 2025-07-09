import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/captchaes/captchaes.css',
                'resources/css/appes/appes.css',
                'resources/css/appes/artiekeles.css',
                'resources/css/appes/artiestories.css',
                'resources/css/appes/artieprofil.css',
                'resources/css/appes/artievides.css',
                'resources/css/appes/mainartievides.css',
                'resources/css/appes/artiestoriesprofil.css',
                'resources/css/authes/authes.css',
                'resources/css/partses/partses.css',
                'resources/css/partses/sidebares.css',
                'resources/css/partses/topbares.css',
                'resources/js/captchaes/captchaes.js',
                'resources/js/partses/topbares.js',
                'resources/js/partses/sidebares.js',
                'resources/js/appes/artieses.js',
                'resources/js/appes/artiestories.js',
                'resources/js/appes/artievides.js',
                'resources/js/appes/artievides1.js',
                'resources/js/appes/artiekeles.js',
                'resources/js/appes/togglemode.js',
                'resources/js/authes/authes.js',
            ],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
})
