const esbuild = require('esbuild');

esbuild.build({
    entryPoints: ['./assets/js/theme.debug.js'],
    bundle: true,
    minify: true,
    treeShaking: true,
    outfile: './assets/js/theme.min.js',
    format: 'iife',
    platform: 'browser',
    target: ['es2020'],
    logLevel: 'info',
    pure: ['console.log', 'console.debug'],
}).catch(() => process.exit(1));