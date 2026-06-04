<template>
  <div
      class="w-full md:max-w-[400px] aspect-[2/3] cursor-pointer"
      @click="toggle"
  >
    <div
        class="relative w-full h-full transition-transform duration-700"
        :style="inner_style"
    >
      <!-- FRONT (рубашка) -->
      <div
          class="absolute inset-0 rounded-xl overflow-hidden"
          style="backface-visibility: hidden;"
      >
        <img
            :src="`/decks/${deck}/back.png`"
            class="w-full h-full object-cover"
            alt="front"
        />
      </div>

      <!-- BACK (карта) -->
      <div
          class="absolute inset-0 rounded-xl overflow-hidden"
          style="backface-visibility: hidden; transform: rotateY(180deg);"
      >
        <img
            :src="cardPath"
            class="w-full h-full object-cover"
            alt="front"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  deck: {
    type: String,
    required: true
  },
  modelValue: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])

const is_flipped = ref(false);
const randomCardIndex = ref('');
const cardPath = computed(() => {
  return `/decks/${props.deck}/${randomCardIndex.value}.png`
})

const toggle = () => {
  if (is_flipped.value) {
    is_flipped.value = false;
    emit('update:modelValue', '')
    availableCardsState.value[props.deck].push(randomCardIndex.value)
    randomCardIndex.value = '';
  } else {
    //console.log(availableCardsState.value[props.deck]);
    const randomArrayIndex = Math.floor(Math.random() * availableCardsState.value[props.deck].length)
    //console.log(randomArrayIndex);
    const randomCardNumber = availableCardsState.value[props.deck][randomArrayIndex];
    //console.log(randomCardNumber);
    availableCardsState.value[props.deck] = availableCardsState.value[props.deck].filter(n => n !== randomCardNumber)
    randomCardIndex.value = randomCardNumber
    is_flipped.value = true;
    emit('update:modelValue', cardPath.value)
  }
}

const inner_style = computed(() => {
  return `
    transform-style: preserve-3d;
    transform: ${is_flipped.value ? 'rotateY(180deg)' : 'rotateY(0deg)'};
  `
})

const availableCardsState = useState('availableCards', () => [])

watch(
    () => props.modelValue,
    (val) => {
      if (val) {
        const match = val.match(/\/(\d+)\.png$/)

        if (match) {
          is_flipped.value = true
          randomCardIndex.value = Number(match[1])
        }
      } else {
        is_flipped.value = false;
        randomCardIndex.value = '';
      }
    },
    {immediate: true}
)

watch(
    () => props.deck,
    (val) => {
      if (val) {
        const match = val.match(/\/(\d+)\.png$/)

        if (match) {
          is_flipped.value = true
          randomCardIndex.value = Number(match[1])
        }
      } else {
        is_flipped.value = false;
        randomCardIndex.value = '';
      }
    },
)
</script>