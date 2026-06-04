<template>
  <div class="flex items-center justify-center gap-2 sm:gap-4 h-full">

    <!-- LEFT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="prev"
        v-if="index > 1"
    >
      <ArrowLeft class="h-6 w-auto" />
    </button>

    <!-- IMAGE -->
    <div class="flex-1 flex items-center justify-center overflow-hidden h-full">
      <img
          :src="imageSrc"
          class="w-full h-auto h-full object-contain rounded-lg"
          :alt="`card-${index}`"
      />
    </div>

    <!-- RIGHT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="next"
        v-if="index < maxCards"
    >
      <ArrowRight class="h-6 w-auto" />
    </button>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import ArrowLeft from '~/assets/icons/arrow-left.svg'
import ArrowRight from '~/assets/icons/arrow-right.svg'

const props = defineProps<{
  deck: string
}>()

const index = ref(1)

const imageSrc = computed(() => {
  return `/decks/${props.deck}/${index.value}.png`
})

function next() {
  if (index.value < maxCards) {
    index.value++
  }
}

function prev() {
  if (index.value > 1) {
    index.value--
  }
}

const decksState = useState<[]>('decks', () => [])
const maxCards = decksState.value.find(d => d.slug === props.deck)?.cardsCount
</script>