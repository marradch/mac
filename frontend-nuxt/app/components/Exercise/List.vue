<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <ExerciseCard
      v-for="exercise in exercises"
      :key="exercise.slug"
      :exercise="exercise"
    />
  </div>
</template>

<script setup lang="ts">
import type { ExerciseCard } from '~/types/Exercise'

const props = withDefaults(defineProps<{
  forHome?: boolean
}>(), {
  forHome: false,
})

const { locale } = useI18n()
const config = useRuntimeConfig()

const url = computed(() =>
  `/exercises${props.forHome ? '-home' : ''}/${locale.value}`
)

const { data: exercises, status, error } = await useFetch<ExerciseCard[]>(url, {
  baseURL: config.public.apiBase,
})
</script>