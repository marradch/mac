<template>
  <div
    class="mx-auto w-full max-w-[220px] aspect-[2/3] cursor-pointer shadow-sm rounded-xl"
    style="perspective: 1200px;"
    @click="showNextCard"
  >
    <div
      class="relative w-full h-full transition-transform duration-[800ms]"
      :style="innerStyle"
    >
      <!-- Рубашка -->
      <div
        class="absolute inset-0 rounded-xl overflow-hidden"
        style="backface-visibility: hidden;"
      >
        <img
          :src="`/decks/${DECK}/back.png`"
          class="w-full h-full object-cover"
          alt="Card back"
        />
      </div>

      <!-- Лицевая сторона карты -->
      <div
        class="absolute inset-0 rounded-xl overflow-hidden"
        style="backface-visibility: hidden; transform: rotateY(180deg);"
      >
        <img
          :src="cardPath"
          class="w-full h-full object-cover"
          alt="Card"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const DECK = 'nature-reflections'
const MAX_CARDS = 30

const currentCard = ref(0)
const isFlipped = ref(true)

const cardPath = computed(
  () => `/decks/${DECK}/${currentCard.value}.png`
)

onMounted(() => {
  currentCard.value = getRandomCard()
})

const innerStyle = computed(() => ({
  transformStyle: 'preserve-3d' as const,
  transform: isFlipped.value
    ? 'rotateY(180deg)'
    : 'rotateY(0deg)',
}))

function getRandomCard(): number {
  return Math.floor(Math.random() * MAX_CARDS) + 1
}

function showNextCard() {
  if (!isFlipped.value) {
    currentCard.value = getRandomCard()
  }

  isFlipped.value = !isFlipped.value
}
</script>