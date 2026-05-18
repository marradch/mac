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
            alt="back"
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
  } else {
    randomCardIndex.value = Math.floor(Math.random() * 2) + 1
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
</script>