<template>
  <section class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
    <div class="flex items-center gap-2">
      <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-pink-50 text-primary-hover">
        <CrownIcon class="h-5 w-5" aria-hidden="true" />
      </span>
      <h2 class="text-lg font-bold text-slate-900">{{ t('home.pro_title') }}</h2>
    </div>

    <p class="mt-4 text-sm leading-relaxed text-slate-700">
      {{ t('home.pro_description') }}
    </p>

    <ul class="mt-4 space-y-3 text-sm text-slate-700">
      <li v-for="benefit in benefits" :key="benefit" class="flex items-center gap-2">
        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-pink-50 text-sm font-bold leading-none text-primary">
        <span class="scale-x-125">✓</span>
        </span>
        {{ benefit }}
      </li>
    </ul>

    <NuxtLink
      to="/login"
      class="mt-6 flex w-full justify-center rounded-lg bg-primary px-4 py-3 text-sm font-bold text-white transition hover:bg-primary-hover"
    >
      {{ t('home.try_pro') }}
    </NuxtLink>
  </section>
</template>

<script setup lang="ts">
import CrownIcon from '~/assets/icons/crown.svg'

const { t } = useI18n()

const benefits = computed(() => [
  t('home.benefits.access'),
  t('home.benefits.decks'),
  t('home.benefits.history'),
  t('home.benefits.meditations')
])
</script>
