import svgLoader from 'vite-svg-loader'

export default defineNuxtConfig({
  vite: {
    server: {
      allowedHosts: ['3c99-193-33-39-62.ngrok-free.app']
    },
    plugins: [svgLoader()]
  },
  runtimeConfig: {
    public: {
      apiBase: '',
      defaultDeckSlug: 'nature-reflections'
    }
  },
  // Глобально подключаем шрифт через Google Fonts
  app: {
    head: {
      link: [
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@400;500;600;700&display=swap'
        }
      ]
    }
  },

  // Настраиваем Tailwind (самый важный момент)
  //css: ['~/assets/scss/main.scss'],

  modules: ['@nuxtjs/tailwindcss', '@nuxtjs/i18n'],

  i18n: {
    langDir: 'locales',
    locales: [
      { code: 'en', name: 'English', file: "en.json" },
      { code: 'uk', name: 'Українська', file: "uk.json" },
      { code: 'ru', name: 'Русский', file: "ru.json" }
    ],
    defaultLocale: 'en',

    vueI18n: './i18n.config.ts',
    strategy: 'prefix',
    detectBrowserLanguage: { useCookie: true, cookieKey: 'i18n_redirected', cookieSecure: false }
  }
})
