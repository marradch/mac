<template>
  <div class="bg-primary shadow-sm border-b fixed top-0 left-0 right-0 z-50">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
      <header class="flex items-center justify-between py-3 md:py-0 relative">

        <!-- БУРГЕР (mobile) -->
        <button
            ref="mobileButtonRef"
            class="md:hidden text-white text-2xl"
            @click="mobileOpen = !mobileOpen"
        >
          {{ mobileOpen ? '✕' : '☰' }}
        </button>

        <!-- ЛОГОТИП (центр на mobile, слева на desktop) -->
        <NuxtLink
            to="/"
            class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0"
        >
          <img src="/logo.png" class="h-16 w-auto" />
        </NuxtLink>

        <!-- КНОПКА РЕГИСТРАЦИИ (mobile) -->
        <!--<button
          type="button"
          @click="isRegModalOpen = !isRegModalOpen"
          class="md:hidden rounded-lg bg-white px-3 py-2 text-md font-semibold text-primary shadow-sm"
        >
          {{ t('header.register') }}
        </button>-->

        <!-- ДЕСКТОП МЕНЮ -->
        <div class="hidden md:flex justify-between items-center w-full ml-6">
          <div class="flex">
            <NuxtLink to="/exercises" class="p-5 text-white hover:bg-primary-hover text-md">
              {{ t('header.exercises') }}
            </NuxtLink>

            <NuxtLink to="/decks" class="p-5 text-white hover:bg-primary-hover text-md">
              {{ t('header.decks') }}
            </NuxtLink>

            <NuxtLink to="/about" class="p-5 text-white hover:bg-primary-hover text-md">
              {{ t('header.about') }}
            </NuxtLink>

            <NuxtLink to="/contacts" class="p-5 text-white hover:bg-primary-hover text-md">
              {{ t('header.contacts') }}
            </NuxtLink>
          </div>

          <!-- RIGHT SIDE -->
          <div class="flex items-center">
            <!-- LANG -->
            <div class="relative">
              <button
                  @click.stop="localesOpen = !localesOpen"
                  class="p-5 text-white hover:bg-primary-hover"
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

            <!-- КНОПКА ВХОДА (desktop) -->
            <button
              type="button"
              @click="isLoginModalOpen = true"
              class="p-5 pe-0 text-white hover:bg-primary-hover text-md"
            >
              {{ t('header.login') }}
            </button>

            <!-- КНОПКА РЕГИСТРАЦИИ (desktop) -->
            <!--<button
              type="button"
              @click="isRegModalOpen = !isRegModalOpen"
              class="rounded-lg bg-white px-4 py-2 text-md font-semibold text-primary shadow-sm transition hover:bg-gray-100"
            >
              {{ t('header.register') }}
            </button>-->
          </div>
        </div>

        <!-- MOBILE MENU -->
        <div
            ref="mobileMenuRef"
            v-if="mobileOpen"
            class="text-lg fixed top-14 left-0 right-0 w-full bg-primary md:hidden flex flex-col"
        >
          <NuxtLink to="/" @click="mobileOpen = false" class="p-4 text-white hover:bg-primary-hover">{{ t('header.exercises') }}</NuxtLink>
          <NuxtLink to="/decks" @click="mobileOpen = false" class="p-4 text-white hover:bg-primary-hover">{{ t('header.decks') }}</NuxtLink>
          <NuxtLink to="/about" @click="mobileOpen = false" class="p-4 text-white hover:bg-primary-hover">{{ t('header.about') }}</NuxtLink>
          <NuxtLink to="/contacts" @click="mobileOpen = false" class="p-4 text-white hover:bg-primary-hover">{{ t('header.contacts') }}</NuxtLink>

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

          <button
            type="button"
            @click="isLoginModalOpen = true; mobileOpen = false"
            class="p-4 text-left text-white"
          >
            {{ t('header.login') }}
          </button>
        </div>
      </header>
    </div>
  </div>

  <GeneralRegisterModal
    :open="isRegModalOpen"
    @close="isRegModalOpen = false"
    @submit="handleRegisterSubmit"
  />

  <GeneralLoginModal
    :open="isLoginModalOpen"
    @close="isLoginModalOpen = false"
    @submit="handleLoginSubmit"
    @switch-to-register="openRegisterModalFromLogin"
  />
</template>

<script setup lang="ts">
const { t, locale, locales, setLocale } = useI18n()
type LocaleCode = 'en' | 'uk' | 'ru'

const localesOpen = ref<boolean>(false)
const mobileOpen = ref<boolean>(false)
const isRegModalOpen = ref<boolean>(false)
const isLoginModalOpen = ref<boolean>(false)
const dropdownRef = ref<HTMLElement | null>(null)
const currentLocale = locale

const mobileMenuRef = ref<HTMLElement | null>(null)
const mobileButtonRef = ref<HTMLElement | null>(null)

const openRegisterModalFromLogin = () => {
  isLoginModalOpen.value = false
  isRegModalOpen.value = true
}

const handleRegisterSubmit = (payload: { name: string; email: string; password: string }) => {
  isRegModalOpen.value = false
}

const handleLoginSubmit = (payload: { email: string; password: string }) => {
  isLoginModalOpen.value = false
}

const handleClickOutside = (event: MouseEvent) => {
  const target = event.target

  if (!(target instanceof Node)) {
    return
  }

  if (dropdownRef.value && !dropdownRef.value.contains(target)) {
    localesOpen.value = false
  }

  if (
    mobileMenuRef.value &&
    !mobileMenuRef.value.contains(target) &&
    !mobileButtonRef.value?.contains(target)
  ) {
    mobileOpen.value = false
  }
}

const changeLocale = async (code: LocaleCode) => {
  await setLocale(code)
  localesOpen.value = false
  mobileOpen.value = false
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>