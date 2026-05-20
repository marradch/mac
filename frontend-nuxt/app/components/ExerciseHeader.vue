<template>
  <div class="mx-auto py-6 text-center">
    <h1 class="text-3xl font-bold mb-3 text-primary">
      {{ exercise?.title }}
    </h1>
    <p class="text-md text-gray-600">
      {{ exercise?.description }}
    </p>
  </div>
</template>

<script setup>
const props = defineProps({
  exercise: {
    type: Object,
    required: true
  }
})

const pageTitle = computed(() => props.exercise?.seo_title ?? '')

useHead({
  title: pageTitle,
  meta: [
    { name: 'description', content: props.exercise?.seo_description },

    { property: 'og:title', content: props.exercise?.seo_title},
    { property: 'og:description', content: props.exercise?.seo_description},
    { property: 'og:type', content: 'website' }
  ]
})
</script>