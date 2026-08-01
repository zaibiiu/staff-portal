export default {
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#f5f7ff',
                    100: '#ebf0fe',
                    200: '#d6e0fd',
                    300: '#b3c5fb',
                    400: '#8ca5f8',
                    500: '#667eea',
                    600: '#5568d3',
                    700: '#4553b8',
                    800: '#3a4695',
                    900: '#323d78',
                    950: '#1e244a',
                },
            },
        },
    },
}
