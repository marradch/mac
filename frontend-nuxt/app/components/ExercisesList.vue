<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <NuxtLink
        v-for="exercise in exercises"
        :key="exercise.id"
        :to="localePath(`/exercises/${exercise.slug}`)"
        class="aspect-square shadow-lg group z-10"
    >
      <img
          :src="`/images/${exercise.slug}.jpg`"
          class="w-full h-2/3 object-cover"
          :alt="exercise.title"
      />

      <div class="h-1/3 bg-primary flex flex-col justify-center p-4 text-white transition-colors duration-300 group-hover:bg-primary-hover">
        <h3 class="text-lg font-bold">
          {{ exercise.title }}
        </h3>

        <p class="text-md text-white">
          {{ exercise.description }}
        </p>
      </div>
    </NuxtLink>
  </div>
</template>

<script setup lang="ts">
const { locale } = useI18n()
const config = useRuntimeConfig()
const localePath = useLocalePath()

interface Exercise {
  id: number
  slug: string
  title: string
  description: string
}

const { data: exercises, status, error } = await useFetch<Exercise[]>(
    `/exercises/${locale.value}`,
    {
      watch: [locale], // 🔥 важно: перезапрос при смене языка
      baseURL: config.public.apiBase
    }
)
</script>