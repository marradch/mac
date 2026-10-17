<template>
  <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
    <div class="flex flex-col gap-8 p-6 md:flex-row md:items-stretch md:p-8">
      <div class="order-1 flex flex-col gap-5 md:flex-1 md:justify-between">
        <div class="flex flex-col gap-3">
          <h1 class="max-w-xl text-3xl font-bold leading-tight text-primary xl:text-4xl">
          {{ t('seo.home.h1') }}!
          </h1>

          <p class="max-w-xl whitespace-pre-line text-sm leading-relaxed text-slate-600 md:text-base">
            {{ t('seo.home.main_hero_text') }}
          </p>

          <p class="hidden xl:block whitespace-pre-line text-sm leading-relaxed text-slate-600 md:text-base">
            {{ t('seo.home.second_hero_text') }}
          </p>
        </div>        

        <div class="hidden md:block overflow-visible whitespace-nowrap">
          <NuxtLink
            to="/exercises"
            class="inline-block min-h-11 rounded-lg bg-primary px-5 py-3 text-sm font-bold text-white transition hover:bg-primary-hover mr-3"
          >
            {{ t('home.start_exercise') }}
          </NuxtLink>

          <NuxtLink
            to="/exercises/resources"
            class="inline-block min-h-11 rounded-lg border border-primary bg-white px-5 py-3 text-sm font-bold text-primary transition hover:bg-pink-50"
          >
            {{ t('home.quick_practice') }}
          </NuxtLink>
        </div>
      </div>

      <div class="order-2 relative mx-auto h-64 w-full md:flex-1 max-w-md sm:h-72 xl:h-80">
        <img
          v-for="(card, index) in cards"
          :key="card.src"
          :src="card.src"
          :alt="t('home.card_alt', { number: index + 1 })"
          class="hero-card absolute left-1/2 top-1/2 h-52 w-36 rounded-xl object-cover shadow-xl sm:h-60 sm:w-40 xl:h-64 xl:w-44"
          :class="card.position"
        >
      </div>

      <div class="d-block md:hidden order-3 flex flex-col gap-3 sm:flex-row justify-center">
        <NuxtLink
          to="/exercises"
          class="inline-flex min-h-11 items-center justify-center rounded-lg bg-primary px-5 py-3 text-sm font-bold text-white transition hover:bg-primary-hover"
        >
          {{ t('home.start_exercise') }}
        </NuxtLink>
        <NuxtLink
          to="/exercises/resources"
          class="inline-flex min-h-11 items-center justify-center rounded-lg border border-primary bg-white px-5 py-3 text-sm font-bold text-primary transition hover:bg-pink-50"
        >
          {{ t('home.quick_practice') }}
        </NuxtLink>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()

const cards = [
  { src: '/design/path-2.png', position: 'hero-card--left' },
  { src: '/design/light.png', position: 'hero-card--center' },
  { src: '/design/tree-2.png', position: 'hero-card--right' }
]
</script>

<style scoped>
.hero-card { transition: transform 220ms ease, box-shadow 220ms ease; }
.hero-card:hover { box-shadow: 0 22px 30px rgb(15 23 42 / 0.24); }
.hero-card--left { z-index: 2; transform: translate(-91%, -45%) rotate(-12deg); }
.hero-card--left:hover { transform: translate(-91%, -54%) rotate(-12deg); }
.hero-card--center {  z-index: 4; transform: translate(-50%, -54%) rotate(2deg); }
.hero-card--center:hover { transform: translate(-50%, -63%) rotate(2deg); }
.hero-card--right { z-index: 6; transform: translate(-9%, -45%) rotate(12deg); }
.hero-card--right:hover { transform: translate(-9%, -54%) rotate(12deg); }
@media (min-width: 1280px) {
  .hero-card--left { transform: translate(-96%, -45%) rotate(-12deg); }
  .hero-card--left:hover { transform: translate(-96%, -54%) rotate(-12deg); }
  .hero-card--right { transform: translate(-4%, -45%) rotate(12deg); }
  .hero-card--right:hover { transform: translate(-4%, -54%) rotate(12deg); }
}
</style>
