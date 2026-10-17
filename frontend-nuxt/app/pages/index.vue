<template>
  <HomeHero />
</template>

<script setup lang="ts">
const { t } = useI18n()

definePageMeta({
  layout: 'payment'
})

useHead({
  title: t('seo.home.title'),
  meta: [
    { name: 'description', content: t('seo.home.description') },
    { property: 'og:title', content: t('seo.home.title') },
    { property: 'og:description', content: t('seo.home.description') },
    { property: 'og:type', content: 'website' }
  ]
})
</script>
