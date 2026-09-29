<template>
<ExerciseSpread v-if="exercise" :exercise="exercise" individual/>
</template>

<script setup lang="ts">
const { exercise } = useExercise('individual-spread')
</script>