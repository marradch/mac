<template>
  <section class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">{{ t('home.how_it_works') }}</h2>

    <ol class="mt-5 space-y-5">
      <li
        v-for="(step, index) in steps"
        :key="step"
        class="flex items-center gap-3 text-sm leading-snug text-slate-700"
      >
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary font-bold text-white">
          {{ index + 1 }}
        </span>
        <span>{{ step }}</span>
      </li>
    </ol>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()

const steps = computed(() => [
  t('home.steps.choose'),
  t('home.steps.card'),
  t('home.steps.answer'),
  t('home.steps.insight')
])
</script>
