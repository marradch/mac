<template>
<ExerciseHeader :exercise="exercise" />
<Spread v-if="exercise" :exercise="exercise" />
</template>

<script setup lang="ts">
import type { Exercise } from "~/types/Exercise";
const { exercise } = useExercise('celtic-cross') as {
  exercise: Ref<Exercise | undefined>
}
</script>