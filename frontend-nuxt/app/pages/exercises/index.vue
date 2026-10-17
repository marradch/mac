<template>
  <div class="mx-auto py-6 text-center">
    <h1 class="text-3xl font-bold mb-3 text-primary">{{ t('seo.exercises.h1') }}!</h1>
    <p class="text-md text-gray-600">{{ t('seo.exercises.main_seo_text') }}</p>
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
</script>
