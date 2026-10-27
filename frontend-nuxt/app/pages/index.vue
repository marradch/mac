<template>
  <HomeHero />

  <section>
    <div class="flex justify-between mb-2 items-center">
      <h2 class="text-slate-600 text-lg font-bold">{{ t('home.topics.title') }}</h2>
      <NuxtLink to="/" class="text-md text-primary hover:text-black font-semibold">
        {{ t('home.topics.all_link') }}
      </NuxtLink>
    </div>
    <TopicList />
  </section>

  <HomeMiniExercise />
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
