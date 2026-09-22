<template>
  <ExerciseHeader :exercise="exercise"/>
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <ExerciseDeckSelection :decks="decks" v-model="deck"/>

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
      <ExerciseTurnCard
          v-model="card.imageUrl"
          :deck="deck"
          manuallySelectable
      ></ExerciseTurnCard>
      <div ref="analisisContentRef" class="scroll-mt-[100px]">
        <HintResultsUsualCard v-if="intelligentAnalisisResult?.analisis_results?.[card.slug]" :hint="intelligentAnalisisResult?.analisis_results?.[card.slug]"/>
      </div>
    </div>
  </div>
  <ExerciseBottomActions
      :loading="loading"
      @hintButtonClick="getIntelligentHintClick"
  />
  <GeneralMessageModal
      v-if="modalMessage"
      :modalMessage="modalMessage"
      @close="clearModalMessage"
  />
</template>
<script setup lang="ts">
import type { Exercise } from "~/types/Exercise"

const props = defineProps<{
  exercise: Exercise
}>()

const { t } = useI18n()
const {decks, resetAvailableCardsState} = await useDecks()

const query = ref<string>('')

const config = useRuntimeConfig()
const deck = ref<string>(config.public.defaultDeckSlug)

const { loading, intelligentAnalisisResult, getIntelligentAnalisis } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()
const { isValidQuery } = useQueryValidation()

const cards = ref<Array<{
  slug: string
  title: string
  imageUrl: string
}>>([])

const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

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

async function getIntelligentHintClick() {
  if (!isValidQuery(query.value) || hasEmptyCards()) {
    showModalMessage('warning', $t('invalid_input'), $t('intelligent_analisis_validation_all'))
    return
  }

  //const origin = useRequestURL().origin
  const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

  await getIntelligentAnalisis('spread', {
    query: query.value,
    cards: cards.value.map(card => ({
      ...card,
      imageUrl: origin + card.imageUrl
    }))
  })

  await nextTick()

  const firstHint = Array.isArray(analisisContentRef.value)
  ? analisisContentRef.value[0]
  : analisisContentRef.value

  firstHint?.scrollIntoView({
    behavior: 'smooth',
    block: 'start'
  })
}

</script>