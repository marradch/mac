<template>
  <div class="flex items-center justify-center gap-2 sm:gap-4 h-full">

    <!-- LEFT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="prev"
        v-if="index > 0"
    >
      <ArrowLeft class="h-6 w-auto" />
    </button>

    <!-- IMAGE -->
    <div class="flex-1 flex items-center justify-center overflow-hidden h-full">
      <img
          :src="imageSrc"
          class="w-full h-auto h-full object-contain rounded-lg"
          :alt="`card-${index}`"
          @click="selectCard"
      />
    </div>

    <!-- RIGHT ARROW -->
    <button
        class="text-primary hover:text-primary-hover transition"
        @click="next"
        v-if="index < maxIndex"
    >
      <ArrowRight class="h-6 w-auto" />
    </button>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import ArrowLeft from '~/assets/icons/arrow-left.svg'
import ArrowRight from '~/assets/icons/arrow-right.svg'

const emit = defineEmits(['selected'])

const props = defineProps<{
  deck: string
}>()

const index = ref(0)

const imageSrc = computed(() => {
  const cardNumber = availableCardsState.value[props.deck][index.value];
  return `/decks/${props.deck}/${cardNumber}.png`
})

function next() {
  if (index.value < maxIndex) {
    index.value++
  }
}

function prev() {
  if (index.value > 0) {
    index.value--
  }
}

const availableCardsState = useState<[]>('availableCards', () => [])
const maxIndex = availableCardsState.value[props.deck].length - 1

function selectCard() {
  const cardNumber = availableCardsState.value[props.deck][index.value];
  emit('selected', imageSrc.value);
  availableCardsState.value[props.deck] = availableCardsState.value[props.deck].filter(n => n !== cardNumber)
  console.log(availableCardsState.value[props.deck])
}
</script>