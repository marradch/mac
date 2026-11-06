<template>
  <div class="mx-auto w-full rounded-xl border border-orange-200 bg-orange-50 p-5 shadow-sm md:p-8">
    <div class="mb-3 flex items-center gap-2">
      <h1 class="text-3xl font-bold text-primary">
        {{ t('seo.exercises.h1') }}
      </h1>
      <span class="text-3xl leading-none text-primary" aria-hidden="true">★</span>
    </div>
    <p class="text-md text-gray-600">
      {{ t('seo.exercises.main_seo_text') }}
    </p>
  </div>
  <ExerciseList />
</template>
<script setup>
const { t } = useI18n()
useHead({
  title: t('seo.exercises.title'),
  meta: [
    { name: 'description', content: t('seo.exercises.description') },

    { property: 'og:title', content: t('seo.exercises.title') },
    { property: 'og:description', content: t('seo.exercises.description') },
    { property: 'og:type', content: 'website' }
  ]
})

definePageMeta({
  layout: 'payment',
  layoutLgBreakpointIncrease: true
})
</script>
