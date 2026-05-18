<template>
  <div class="mx-auto py-6 text-center">
    <h1 class="text-3xl font-bold mb-3 text-primary">{{ t('seo.h1') }}!</h1>
    <p class="text-md text-gray-600">{{ t('seo.main_seo_text') }}</p>
  </div>
  <ExercisesList />
</template>
<script setup>
const { t } = useI18n()
useHead({
  title: t('seo.title'),
  meta: [
    { name: 'description', content: t('seo.description') },

    { property: 'og:title', content: t('seo.title') },
    { property: 'og:description', content: t('seo.description') },
    { property: 'og:type', content: 'website' }
  ]
})
</script>