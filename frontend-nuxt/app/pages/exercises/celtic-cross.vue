<template>
<Spread v-if="exercise" :exercise="exercise" />
</template>

<script setup lang="ts">
const { exercise } = useExercise('celtic-cross')
</script>