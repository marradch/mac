<template>
  <NuxtLink
    :key="exercise.title"
    :to="localePath(`/exercises/${exercise.slug}`)"
    class="rounded-xl bg-white p-3 shadow-sm transition hover:shadow-md"
  >
    <div class="mb-3 overflow-hidden rounded-lg">
      <img src="/design/tree-2.png" :alt="exercise.title" class="aspect-[3/2] w-full object-cover" />
    </div>

    <div class="flex justify-between gap-2 text-[13px] font-medium text-slate-600">
        <div class="flex gap-2">
        <div class="flex items-center gap-1.5 py-1.5">
            <ClockIcon class="h-4 w-4 text-slate-500" />
            <span class="leading-none relative top-px">{{ exercise.minExecutionMin }}-{{ exercise.maxExecutionMin }} {{ $t('exercise.min') }}</span>
        </div>

        <div class="flex items-center gap-1.5 py-1.5">
            <StarIcon class="h-4 w-4 text-slate-500" />
            <span class="leading-none relative top-px">{{ $t(`exercise.difficulty.${exercise.difficulty}`) }}</span>
        </div>
        </div>
        
        <div
        class="flex items-center justify-center rounded-full border px-3 py-1.5 text-center"
        :class="exercise.slug !== 'question-to-card' ? 'border-slate-300 text-slate-700' : 'border-orange-200 bg-orange-50 text-orange-700'"
        >
        {{ exercise.slug !== 'question-to-card' ? 'Pro' : $t('exercise.free') }}
        </div>
    </div>

    <h3 class="mt-3 text-lg font-bold text-slate-900">{{ exercise.title }}</h3>

    <p class="mt-2 text-sm leading-6 text-slate-600">
        {{ exercise.description }}
    </p>
    </NuxtLink>
</template>

<script setup lang="ts">
import type { ExerciseCard } from '~/types/Exercise'

import ClockIcon from '~/assets/icons/clock.svg'
import StarIcon from '~/assets/icons/star-outline.svg'

const props = defineProps<{
  exercise: ExerciseCard
}>()

const localePath = useLocalePath()
</script>
