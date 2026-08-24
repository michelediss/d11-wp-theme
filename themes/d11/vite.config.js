/*
 * Vite build configuration for the theme asset pipeline. It outputs the manifest and bundled
 * front-end files consumed by the WordPress enqueue layer.
 */

import { defineConfig } from 'vite';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  base: './',
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    origin: 'http://localhost:5173',
  },
  build: {
    manifest: true,
    outDir: 'assets',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: path.resolve(dirname, 'src/js/app.js'),
        blockEditor: path.resolve(dirname, 'src/js/blocks/editor.js'),
        blockView: path.resolve(dirname, 'src/js/blocks/view.js'),
        blockAvailabilityAdmin: path.resolve(dirname, 'src/js/admin/block-availability-admin.js'),
        blockAvailabilityAdminStyle: path.resolve(dirname, 'src/css/admin/block-availability-admin.css'),
        blocksStyle: path.resolve(dirname, 'src/css/blocks.css'),
        defaultFeaturedImageAdmin: path.resolve(dirname, 'src/js/admin/default-featured-image-admin.js'),
        defaultFeaturedImageAdminStyle: path.resolve(dirname, 'src/css/admin/default-featured-image-admin.css'),
        editorStyle: path.resolve(dirname, 'src/css/editor.css'),
        editorSeo: path.resolve(dirname, 'src/js/editor-seo.js'),
        privacyStyle: path.resolve(dirname, 'src/css/privacy.css'),
        style: path.resolve(dirname, 'src/css/app.css'),
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: ({ name }) => {
          if (name && name.endsWith('.css')) {
            return 'css/[name][extname]';
          }

          return 'assets/[name][extname]';
        },
      },
    },
  },
});
