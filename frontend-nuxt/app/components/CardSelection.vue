<template>
  <div class="flex items-center justify-center gap-2 sm:gap-4">

    <!-- LEFT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="prev"
        :disabled="index <= 1"
    >
      <svg xmlns="http://www.w3.org/2000/svg"
           class="h-6 w-auto"
           fill="none"
           viewBox="7 4 9 16"
           stroke="currentColor">
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- IMAGE -->
    <div class="flex-1 flex items-center justify-center overflow-hidden">
      <img
          :src="imageSrc"
          class="w-full h-auto sm:max-w-[350px] object-contain rounded-lg"
          :alt="`card-${index}`"
      />
    </div>

    <!-- RIGHT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="next"
    >
      <svg xmlns="http://www.w3.org/2000/svg"
           class="h-6 w-auto"
           fill="none"
           viewBox="8 4 9 16"
           stroke="currentColor">
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7" />
      </svg>
    </button>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const props = defineProps<{
  deck: string
  max?: number
}>()

const index = ref(1)

// если не передали max — по дефолту 100 карт
const maxCards = computed(() => props.max ?? 100)

const imageSrc = computed(() => {
  return `/decks/${props.deck}/${index.value}.png`
})

function next() {
  if (index.value < maxCards.value) {
    index.value++
  }
}

function prev() {
  if (index.value > 1) {
    index.value--
  }
}
</script>