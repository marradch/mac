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
        <EmotionCardHintResults :hint="intelligentHint[index]" />
      </div>
    </div>

    <div class="flex flex-col gap-3 items-center justify-start">
      <div class="w-full md:max-w-[400px] sm:mt-[80px]">
        <button
            type="button"
            class="w-full aspect-[2/3] rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-gray-400 transition flex items-center justify-center"
            @click="addCardWithRandomState"
        >
          <span
              class="text-[60px] text-gray-500"
          >
            +
          </span>
        </button>
      </div>
    </div>
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
  return psychologicalStates.value[Math.floor(Math.random() * psychologicalStates.value.length)]
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

addCardWithRandomState();

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