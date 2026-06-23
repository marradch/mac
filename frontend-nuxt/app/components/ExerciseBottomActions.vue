<template>
  <div class="fixed bottom-4 right-4 z-50 flex flex-col items-end gap-2">

    <ExerciseHintError
        v-if="error"
        :error="error"
        @close="emit('closeError')"
    />

    <ExerciseLoadingHintButton
        :loading="loading"
        @click="emit('hintButtonClick')"
    />

  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  error: string
  loading: boolean
}>()

const emit = defineEmits<{
  (e: 'closeError'): void
  (e: 'hintButtonClick'): void
}>()
</script>