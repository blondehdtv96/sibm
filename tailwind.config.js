export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            colors: {
                // School brand palette, derived from the navy/blue already used
                // across the public site so new markup stays consistent.
                brand: {
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#3B82F6',
                    600: '#1D4ED8',
                    700: '#1E3A8A',
                    800: '#15306B',
                    900: '#0B1F4B',
                    950: '#07142F',
                },
            },
            boxShadow: {
                card: '0 1px 2px rgba(11, 31, 75, .04), 0 8px 24px -12px rgba(11, 31, 75, .14)',
                'card-hover': '0 2px 4px rgba(11, 31, 75, .06), 0 24px 48px -20px rgba(11, 31, 75, .28)',
            },
            keyframes: {
                'marquee-left': {
                    from: { transform: 'translateX(0)' },
                    to: { transform: 'translateX(-50%)' },
                },
            },
            animation: {
                'marquee-left': 'marquee-left 40s linear infinite',
            },
        },
    },
    plugins: [],
};
