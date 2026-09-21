<template>
  <div class="fixed bottom-4 right-4 z-50 flex flex-col items-end gap-2">


    <ExerciseLoadingHintButton
        :loading="loading"
        @click="emit('hintButtonClick')"
    />

  </div>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  error?: string
  loading: boolean
}>(), {
  error: '',
})

const emit = defineEmits<{
  (e: 'closeError'): void
  (e: 'hintButtonClick'): void
}>()
</script>