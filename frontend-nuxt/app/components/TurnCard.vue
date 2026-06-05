<template>
  <div
      class="w-full md:max-w-[400px] aspect-[2/3] cursor-pointer"
      @click="toggle"
  >
    <div
        class="relative w-full h-full transition-transform duration-700"
        :style="inner_style"
    >
      <div
          class="
            absolute top-[20px]
            w-[30px] h-[30px]
            bg-primary
            rounded-full

            flex items-center justify-center
            cursor-pointer

            text-white text-[20px] leading-none
            z-[99999]
            hover:bg-primary-hover
          "
          :class="is_flipped ? 'left-[20px]' : 'right-[20px]'"
          @click="emit('remove')"
      >
        ✕
      </div>
      <!-- FRONT (рубашка) -->
      <div
          class="absolute inset-0 rounded-xl overflow-hidden"
          style="backface-visibility: hidden;"
      >
        <img
            :src="`/decks/${deckRef}/back.png`"
            class="w-full h-full object-cover"
            alt="back"
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
    required: false
  },
  modelValue: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue', 'remove'])

const is_flipped = ref(false);
const randomCardIndex = ref('');
const cardPath = computed(() => {
  if (randomCardIndex.value) {
    return `/decks/${deckRef.value}/${randomCardIndex.value}.png`
  } else {
    return `/decks/${deckRef.value}/back.png`
  }
})

const internalChange = ref('');
const deckRef = ref('');
deckRef.value = props.deck ?? '';

const toggle = () => {
  internalChange.value = true

  if (is_flipped.value) {
    is_flipped.value = false;

    availableCardsState.value[deckRef.value].push(randomCardIndex.value)
    //randomCardIndex.value = '';
    emit('update:modelValue', '')
  } else {
    //console.log(availableCardsState.value[props.deck]);
    const randomArrayIndex = Math.floor(Math.random() * availableCardsState.value[deckRef.value].length)
    //console.log(randomArrayIndex);
    const randomCardNumber = availableCardsState.value[deckRef.value][randomArrayIndex];
    //console.log(randomCardNumber);
    availableCardsState.value[deckRef.value] = availableCardsState.value[deckRef.value].filter(n => n !== randomCardNumber)
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
      if (internalChange.value == true) {
        internalChange.value = false

        return
      }

      if (val) {
        const match = val.match(/^\/decks\/([^/]+)\/(\d+)\.png$/)
        if (match) {
          is_flipped.value = true
          randomCardIndex.value = Number(match[2])
          deckRef.value = match[1]
        }
      } else {
        is_flipped.value = false;
        randomCardIndex.value = '';
      }
    },
    {immediate: true}
)
</script>