<template>
  <div class="flex flex-col items-start">
    <span
      class="mb-3 inline-flex items-center rounded-full
             bg-orange-100 px-3 py-1
             text-xs font-semibold uppercase tracking-wider
             text-orange-800"
    >
      {{ t('home.mini_exercise.try_now') }}
    </span>

    <h2 class="text-2xl font-bold leading-tight text-slate-900">
      {{ t('home.mini_exercise.title') }}
    </h2>

    <p class="mt-3 text-sm leading-6 text-slate-600">
      {{ t('home.mini_exercise.description') }}
    </p>

    <h3 class="mt-6 text-lg font-bold text-slate-900">
      {{ t('home.mini_exercise.question_title') }}
    </h3>

    <p class="mt-2 text-sm leading-6 text-slate-600">
      {{ t('home.mini_exercise.question_prompt') }}
    </p>

    <p class="mt-3 flex items-center gap-2 text-sm leading-5 text-slate-700">
      <InfoIcon class="h-5 w-5 shrink-0 text-orange-600" />
      {{ t('home.mini_exercise.self_reflection_note') }}
    </p>

    <p class="mt-3 flex items-center gap-2 text-sm leading-5 text-slate-700">
      <ClockIcon class="h-5 w-5 shrink-0 text-orange-600" />
      {{ t('home.mini_exercise.short_explanation') }}
    </p>
  </div>
</template>

<script setup lang="ts">
import InfoIcon from '~/assets/icons/info.svg'
import ClockIcon from '~/assets/icons/clock.svg'

const { t } = useI18n()
</script>