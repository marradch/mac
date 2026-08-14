<template>
  <div
      class="w-full md:max-w-[400px] aspect-[2/3] cursor-pointer"
      @click="toggle"
  >
    <div
        class="relative w-full h-full transition-transform duration-700"
        :style="innerStyle"
    >
      <div v-if="removable"
          class="
            absolute top-[10px]
            w-[30px] h-[30px]
            bg-primary
            rounded-full

            flex items-center justify-center
            cursor-pointer

            text-white text-[20px] leading-none
            z-[99999]
            hover:bg-primary-hover
          "
          :class="isFlipped ? 'left-[20px]' : 'right-[20px]'"
          @click="emit('remove')"
      >
        ✕
      </div>
      <div v-if="manuallySelectable && !isFlipped"
        class="
          absolute top-[40px]
          left-1/2 -translate-x-1/2

          px-4 py-2

          min-w-[116px]
          whitespace-nowrap

          bg-white rounded-full
          cursor-pointer
          text-gray-600

          z-[999999]
          hover:bg-orange-200
        "
        @click.stop="isModalOpen = true"
      >
        {{$t('select_manually')}}
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

  <BaseModal
      :open="isModalOpen"
      h-full
      @close="isModalOpen = false"
  >
    <CardSelection :deck="deck" @selected="(value) => selectCard(value)"/>

    <template #header>
      {{ $t('choose_card') }}
    </template>
  </BaseModal>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  deck: string
  modelValue?: string
  removable?: boolean
  manuallySelectable?: boolean
}>(), {
  modelValue: '',
  removable: false,
  manuallySelectable: false
})

const emit = defineEmits<{
  'update:modelValue': [value: string],
  'remove': [],
}>()

const isFlipped = ref<boolean>(false)
const randomCardIndex = ref<number>(0)
const internalChange = ref<boolean>(false)
const deckRef = ref<string>('')
deckRef.value = props.deck ?? ''

const cardPath = computed(() => {
  if (randomCardIndex.value) {
    return `/decks/${deckRef.value}/${randomCardIndex.value}.png`
  } else {
    return `/decks/${deckRef.value}/back.png`
  }
})

watch(
    () => props.deck,
    (newDeck) => {
      deckRef.value = newDeck ?? ''
    }
)

const toggle = () => {
  internalChange.value = true

  if (isFlipped.value) {
    isFlipped.value = false

    availableCardsState.value?.[deckRef.value]?.push(randomCardIndex.value)
    //randomCardIndex.value = ''
    emit('update:modelValue', '')
  } else {
    //console.log(availableCardsState.value[props.deck])
    const randomArrayIndex = Math.floor(Math.random() * (availableCardsState.value?.[deckRef.value]?.length ?? 0))
    //console.log(randomArrayIndex)
    const randomCardNumber = availableCardsState.value?.[deckRef.value]?.[randomArrayIndex] ?? 0
    //console.log(randomCardNumber)
    availableCardsState.value[deckRef.value] = availableCardsState.value?.[deckRef.value]?.filter(n => n !== randomCardNumber) ?? []
    randomCardIndex.value = randomCardNumber
    isFlipped.value = true
    emit('update:modelValue', cardPath.value)
  }
}

const innerStyle = computed(() => {
  return `
    transform-style: preserve-3d;
    transform: ${isFlipped.value ? 'rotateY(180deg)' : 'rotateY(0deg)'}
  `
})

const availableCardsState = useState<Record<string, number[]>>('availableCards', () => ({}))

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
          isFlipped.value = true
          randomCardIndex.value = Number(match[2])
          deckRef.value = String(match[1])
        }
      } else {
        isFlipped.value = false
        randomCardIndex.value = 0
      }
    },
    {immediate: true}
)

const isModalOpen = ref(false)

function selectCard(val: string) {
  const match = val.match(/^\/decks\/([^/]+)\/(\d+)\.png$/)
  if (match) {
    isFlipped.value = true
    randomCardIndex.value = Number(match[2])
    isModalOpen.value = false
  }
}
</script>