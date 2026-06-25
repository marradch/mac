<template>
  <ExerciseHeader :exercise="exercise"/>
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <ChooseDeck :decks="decks" v-model="deck"/>

      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
    </div>
  </div>
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-5">
    <div v-for="(card, index) in cards" :key="card.slug" class="flex flex-col gap-3 items-center justify-start">
      <p class="text-gray-600 text-center lg:truncate w-full" :title="card.title">{{ card.title }}</p>
      <TurnCard
          v-model="card.imageUrl"
          :deck="deck"
          manuallySelectable
      ></TurnCard>
      <div v-if="intelligentHint?.cards_interpretations?.[card.slug]?.interpretation" class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
        {{ intelligentHint?.cards_interpretations?.[card.slug].interpretation }}
      </div>
      <div v-if="intelligentHint?.cards_interpretations?.[card.slug]?.interpretation" class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
        {{ intelligentHint?.cards_interpretations?.[card.slug].affirmation }}
      </div>
      <div v-if="intelligentHint?.cards_interpretations?.[card.slug]?.meditation" class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
        {{ intelligentHint?.cards_interpretations?.[card.slug].meditation }}
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
import type {Exercise} from "~/types/Exercise"

const props = defineProps<{
  exercise: Exercise
}>()

const {t, locale} = useI18n()
const {decks, resetAvailableCardsState} = await useDecks()

const query = ref<string>('')
const error = ref<string>('')
const intelligentHint = ref<any>({})
const config = useRuntimeConfig()
const deck = ref<string>(config.public.defaultDeckSlug)
const loading = ref<boolean>(false);

const cards = ref<Array<{
  slug: string
  title: string
  imageUrl: string
}>>([])

const cardsContentRef = ref<HTMLElement | null>(null)

cards.value = props.exercise?.spread?.map(spreadItem => ({
  ...spreadItem,
  imageUrl: "",
})) ?? []

watch(deck, () => {
  cards.value.forEach(card => (card.imageUrl = ''))
  resetAvailableCardsState()
})

function hasEmptyCards() {
  return cards.value.some((card) => !card.imageUrl)
}

async function getIntelligentHint() {
  error.value = ''

  if (!query.value || hasEmptyCards()) {
    error.value = $t('intelligent_hint_validation_all')
    return
  }

  try {
    loading.value = true

    //const origin = useRequestURL().origin
    const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

    intelligentHint.value = await $fetch(`/spread/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        query: query.value,
        cards: cards.value.map(card => ({
          ...card,
          imageUrl: origin + card.imageUrl
        }))
      }
    })

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