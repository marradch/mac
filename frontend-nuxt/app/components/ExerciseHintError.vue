<template>
<div
    v-if="error"
    class="relative bg-primary text-white shadow-md rounded-md px-3 py-2 max-w-sm w-full md:w-fit"
>
  <button
      class="absolute top-2 right-2 text-white hover:text-gray-600"
      @click="emit('close')"
      type="button"
  >
    ✕
  </button>

  <div class="pr-6">
    {{error}}
  </div>
</div>
</template>

<script setup>
defineProps({
  error: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['close'])
</script>