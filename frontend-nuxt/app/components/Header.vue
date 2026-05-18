<template>
  <header class="flex items-center justify-between py-3 md:py-0 relative">

    <!-- БУРГЕР (mobile) -->
    <button
        class="md:hidden text-white text-lg"
        @click="mobileOpen = !mobileOpen"
    >
      {{ mobileOpen ? '✕' : '☰' }}
    </button>

    <!-- ЛОГОТИП (центр на mobile, слева на desktop) -->
    <NuxtLink
        to="/"
        class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0"
    >
      <img src="/logo.png" class="h-14 w-auto" />
    </NuxtLink>

    <!-- ДЕСКТОП МЕНЮ -->
    <div class="hidden md:flex justify-between items-center w-full ml-6">

      <div class="flex">
        <NuxtLink to="/" class="p-4 text-white hover:bg-primary-hover">
          {{ t('header.exercises') }}
        </NuxtLink>

        <NuxtLink to="/decks" class="p-4 text-white hover:bg-primary-hover">
          {{ t('header.decks') }}
        </NuxtLink>

        <NuxtLink to="/about" class="p-4 text-white hover:bg-primary-hover">
          {{ t('header.about') }}
        </NuxtLink>

        <NuxtLink to="/contacts" class="p-4 text-white hover:bg-primary-hover">
          {{ t('header.contacts') }}
        </NuxtLink>
      </div>

      <!-- RIGHT SIDE -->
      <div class="flex items-center">
        <!-- LANG -->
        <div class="relative">
          <button
              @click.stop="localesOpen = !localesOpen"
              class="p-4 text-white hover:bg-primary-hover"
          >
            {{ currentLocale.toUpperCase() }} ▾
          </button>

          <div
              v-if="localesOpen"
              class="absolute right-0 bg-primary text-white shadow-lg"
              ref="dropdownRef"
          >
            <button
                v-for="locale in locales"
                :key="locale.code"
                @click="changeLocale(locale.code)"
                class="block w-full text-left px-4 py-2 hover:bg-primary-hover"
            >
              {{ locale.name }}
            </button>
          </div>
        </div>

        <NuxtLink to="/login" class="p-4 text-white hover:bg-primary-hover">
          {{ t('header.login') }}
        </NuxtLink>
      </div>
    </div>

    <!-- MOBILE MENU -->
    <div
        v-if="mobileOpen"
        class="text-lg fixed top-12 left-0 right-0 w-full bg-primary md:hidden flex flex-col"
    >
      <NuxtLink to="/" class="p-4 text-white hover:bg-primary-hover">{{ t('header.exercises') }}</NuxtLink>
      <NuxtLink to="/decks" class="p-4 text-white hover:bg-primary-hover">{{ t('header.decks') }}</NuxtLink>
      <NuxtLink to="/about" class="p-4 text-white hover:bg-primary-hover">{{ t('header.about') }}</NuxtLink>
      <NuxtLink to="/contacts" class="p-4 text-white hover:bg-primary-hover">{{ t('header.contacts') }}</NuxtLink>

      <!-- 🌐 LANG SWITCHER -->
      <div class="flex gap-2 px-4">
        <button
            v-for="locale in locales"
            :key="locale.code"
            @click="changeLocale(locale.code)"
            class="px-3 py-1 text-white text-sm rounded transition"
            :class="{
              'bg-primary-hover': currentLocale !== locale.code,
              'bg-white/20 font-semibold': currentLocale === locale.code
            }"
        >
          {{ locale.code.toUpperCase() }}
        </button>
      </div>

      <NuxtLink to="/login" class="p-4 text-white">{{ t('header.login') }}</NuxtLink>
    </div>

  </header>
</template>

<script setup>
const { t, locale, locales, setLocale } = useI18n()

const localesOpen = ref(false)
const mobileOpen = ref(false)
const dropdownRef = ref(null)


const currentLocale = locale

const changeLocale = async (code) => {
  await setLocale(code)
  open.value = false
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    localesOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>