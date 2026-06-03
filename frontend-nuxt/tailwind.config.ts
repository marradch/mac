export default {
    content: [
        './components/**/*.{vue,js,ts}',
        './layouts/**/*.vue',
        './pages/**/*.vue',
        './app.vue'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Merriweather Sans', 'Arial', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#ff435d',
                    hover: '#DA324A',
                }
            }
        }
    }
}