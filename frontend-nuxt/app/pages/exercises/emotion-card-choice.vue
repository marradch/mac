<template>
  <ExerciseHeader :exercise="exercise"/>
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <ChooseDeck :decks="decks" v-model="deck"/>
    </div>
  </div>
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-5">
    <div
        v-for="(card, index) in cards"
        :key="card.stateSlug"
        class="flex flex-col gap-3 items-center justify-start"
    >
      <div class="w-full md:max-w-[400px]">
        <p
            class="cursor-pointer bg-orange-200 hover:bg-orange-300 w-full text-center p-4 mb-5 rounded-lg border border-gray-200/80 font-medium shadow-sm"
            :title="card.stateTitle"
            @click="replaceCardWithRandomState(index)"
        >
          {{ card.stateTitle }}
        </p>

        <TurnCard
            v-model="card.imageUrl"
            :deck="card.deck"
            manuallySelectable
            removable
            @remove="removeCardByIndex(index)"
        />

        <!-- Intelligent Hint under card -->
        <EmotionCardHintResults :hint="intelligentHint?.[card.stateSlug]" />
      </div>
    </div>

    <AddCardTile @click="addCardWithRandomState" hasMt/>
  </div>  
  <ExerciseBottomActions
      :error="error"
      :loading="loading"
      @closeError="error = ''"
      @hintButtonClick="getIntelligentHint"
  />


</template>
<script setup lang="ts">
import type { PsychologicalState } from '~/types/PsychologicalState'

const { locale, t: $t } = useI18n()
const { decks } = await useDecks()
const { exercise } = useExercise('emotion-card-choice')

const error = ref<string>('')
const intelligentHint = ref<any[]>([])
const config = useRuntimeConfig()
const deck = ref<string>(config.public.defaultDeckSlug)
const loading = ref<boolean>(false)

const { data: psychologicalStates } = await useFetch<PsychologicalState[]>(
    () => `/psychological-states/${locale.value}`,
    {
      baseURL: config.public.apiBase,
      key: () => `psychological-states-${locale.value}`,
      watch: [locale],
      getCachedData: (key) => {
        return useNuxtApp().payload.data[key]
      },
    }
)

type CardWithState = {
  stateTitle: string
  stateSlug: string
  imageUrl: string,
  deck: string
}

const cards = ref<CardWithState[]>([])

function removeCardByIndex(index: number) {
  cards.value = cards.value.filter((_, i) => i !== index)
}

function pickRandomState(): PsychologicalState | undefined {
  if (!psychologicalStates.value || !psychologicalStates.value.length) {
    return undefined
  }
  
  // Получить список уже выбранных slug'ов
  const usedSlugs = cards.value.map(card => card.stateSlug)
  
  // Исключить уже выбранные состояния
  const availableStates = psychologicalStates.value.filter(
    state => !usedSlugs.includes(state.slug)
  )
  
  if (!availableStates.length) {
    return undefined
  }
  
  return availableStates[Math.floor(Math.random() * availableStates.length)]
}

function addCardWithRandomState() {
  const randomState = pickRandomState()

  if (!randomState) {
    return
  }

  cards.value = [...cards.value, {
    stateTitle: randomState.title,
    stateSlug: randomState.slug,
    deck: deck.value,
    imageUrl: '',
  }]
}

function replaceCardWithRandomState(index: number) {
  const randomState = pickRandomState()

  if (!randomState || index < 0 || index >= cards.value.length || cards.value[index] === undefined) {
    return
  }

  cards.value[index] = {
    stateTitle: randomState.title,
    stateSlug: randomState.slug,
    imageUrl: '',
    deck: deck.value,
  }
}

onMounted(() => {
  addCardWithRandomState()
})

const cardsContentRef = ref<HTMLElement | null>(null)

function hasEmptyCards() {
  return cards.value.some((card) => !card.imageUrl)
}

async function getIntelligentHint() {
  error.value = ''

  if (hasEmptyCards()) {
    error.value = $t('intelligent_hint_validation_all')
    return
  }

  try {
    loading.value = true

    //const origin = useRequestURL().origin
    const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

    intelligentHint.value = await $fetch(`/emotion-and-card/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        cards: cards.value.map(card => ({
          stateSlug: card.stateSlug,
          imageUrl: origin + card.imageUrl
        }))
      }
    })

    console.log('intelligentHint.value', intelligentHint.value)

    await nextTick()
    
    cardsContentRef.value?.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  } catch (errorResponse: any) {
    const responseData = errorResponse?.data ?? errorResponse?.response?._data

    if (responseData?.type === 'retryable_error') {
      error.value = $t('Something went wrong. Please, try again')
    } else {
      error.value = $t(`Something went wrong`)
    }
    console.log(errorResponse)
  } finally {
    loading.value = false
  }
}

</script>