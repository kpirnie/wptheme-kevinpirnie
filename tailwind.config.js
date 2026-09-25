module.exports = {
    content: [
        './*.php',
        './partials/**/*.php',
        './work/kpt.php',
        './work/inc/**/*.php',
        './assets/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                'kp-light-blue': '#599bb8',
                'kp-lightish-blue': '#43819c',
                'kp-orange': '#fd6a4f',
                'kp-gray': '#2d7696',
                'kp-darkish-blue': '#599bb8',
                'kp-dark-blue': '#43819c',
                'kp-darkest-blue': '#2d7696',
                'kp-navy': '#000d2d',
            },
            fontFamily: {
                'mono': ['Source Code Pro', 'monospace'],
            },
        },
    },
    plugins: [],
    safelist: [
        'active',
        'prev',
        'hidden',
        'opacity-0',
        'opacity-100',
        'visible',
        'invisible',
        'rotate-180',
    ],
}