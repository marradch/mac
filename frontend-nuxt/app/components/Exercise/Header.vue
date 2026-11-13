<template>
  <div class="mx-auto mb-6 w-full rounded-xl border border-orange-200 bg-orange-50 p-5 shadow-sm md:p-8">
    <div class="mb-3 flex items-center gap-2">
      <h1 class="text-3xl font-bold text-primary">
        {{ exercise?.title }}
      </h1>
      <span class="text-3xl leading-none text-primary" aria-hidden="true">★</span>
    </div>
    <p class="text-md text-gray-600">
      {{ exercise?.description }}
    </p>
  </div>
</template>

<script setup lang="ts">
import type { Exercise } from "~/types/Exercise"

const props = defineProps<{
  exercise?: Exercise
}>()

useHead(() => ({
  title: props.exercise?.seoTitle,
  meta: [
    { name: 'description', content: props.exercise?.seoDescription },
    { property: 'og:title', content: props.exercise?.seoTitle },
    { property: 'og:description', content: props.exercise?.seoDescription },
    { property: 'og:type', content: 'website' }
  ]
}))
</script>