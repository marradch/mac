<template>
  <ExerciseHeader :exercise="exercise"/>
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <ExerciseDeckSelection :decks="decks" v-model="deck"/>
      <div class="flex flex-col md:flex-row gap-3 items-center">        
        <textarea
            v-model="query"
            :placeholder="$t('query_placeholder')"
            rows="1"
            class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
        />
        <ExerciseLoadingAIButton 
          v-if="individual"
          :loading="loadingIndividualSpread"
          @click="getIndividualSpreadClick"
          class="md:min-w-[200px] h-fit">
          {{ $t('get_spread') }}
        </ExerciseLoadingAIButton>
      </div>      
    </div>
  </div>
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-5">
    <div v-for="(card, index) in cards" :key="card.slug" class="flex flex-col gap-3 items-center justify-end">
      <p class="text-gray-600 text-center w-full" :title="card.title">{{ card.title }}</p>
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
  <HintResultsMeditation 
    v-if="intelligentAnalisisResult?.meditation" 
    :meditation="intelligentAnalisisResult?.meditation"
    class="mb-3"/>
  <ExerciseBottomActions
      :loading="loading"
      @hintButtonClick="intellgentAnalisisConfirm"
  />
  <GeneralMessageModal
      v-if="modalMessage"
      :modalMessage="modalMessage"
      @close="clearModalMessage"
  />
  <ExerciseHintConfirmationModal
      :open="isConfirmationModalOpen"
      @close="isConfirmationModalOpen = false"
      @confirm="getIntelligentAnalisisClick"
  />
</template>
<script setup lang="ts">
import type { Exercise } from "~/types/Exercise"

const props = withDefaults(
  defineProps<{
    exercise: Exercise
    individual?: boolean
  }>(),
  {
    individual: false,
  }
)

const { t } = useI18n()
const {decks, resetAvailableCardsState} = await useDecks()

const query = ref<string>('')

const config = useRuntimeConfig()
const deck = ref<string>(config.public.defaultDeckSlug)
const isConfirmationModalOpen = ref(false)
const isQueryAndCardsActual = ref(true)
const isQueryActual = ref(true)
const shouldValidateQueryActuality = ref(false)

const { loading, intelligentAnalisisResult, getIntelligentAnalisis } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()
const { isValidQuery } = useQueryValidation()

const { loadingIndividualSpread, getIndividualSpread } = useIndividualSpread()

const cards = ref<Array<{
  slug: string
  title: string
  imageUrl: string
}>>([])

const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

if (!props.individual) {
  cards.value = props.exercise?.spread?.map(spreadItem => ({
    ...spreadItem,
    imageUrl: "",
  })) ?? []
}

watch(
  [cards, query],
  ([newCards, newQuery], [oldCards, oldQuery]) => {
    isQueryAndCardsActual.value = true
  },
  { deep: true }
)

watch(
  [query],
  ([newQuery], [oldQuery]) => {
    isQueryActual.value = true
  }
)

watch(deck, () => {
  cards.value.forEach(card => (card.imageUrl = ''))
  resetAvailableCardsState()
})

function hasEmptyCards() {
  return cards.value.some((card) => !card.imageUrl)
}

function intellgentAnalisisConfirm() {
  if (shouldValidateQueryActuality.value && !isQueryActual.value) {
    showModalMessage('warning', t('dublicate_query'), t('dublicate_query_message'))
    return
  }
  if (!isQueryAndCardsActual.value) {
    showModalMessage('warning', $t('dublicate_input'), $t('dublicate_input_message'))
    return
  }
  if (!isValidQuery(query.value) || hasEmptyCards() || !cards.value.length) {
    showModalMessage('warning', $t('invalid_input'), $t('intelligent_analisis_validation_all'))
    return
  }
  isConfirmationModalOpen.value = true
}

async function getIntelligentAnalisisClick() {
  isConfirmationModalOpen.value = false

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

  isQueryAndCardsActual.value = false
  isQueryActual.value = false
  shouldValidateQueryActuality.value = (intelligentAnalisisResult.value?.query_status !== 'valid')  

  if (intelligentAnalisisResult.value?.query_status === 'valid') {
    await nextTick()
    
    const firstHint = Array.isArray(analisisContentRef.value)
    ? analisisContentRef.value[0]
    : analisisContentRef.value

    firstHint?.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  }
}

async function getIndividualSpreadClick()
{
  if (!isValidQuery(query.value)) {
    showModalMessage('warning', $t('invalid_query_title'), $t('invalid_query_message'))
    return
  }

  const individualSpreadResults = await getIndividualSpread(query.value)

  cards.value = individualSpreadResults?.spread?.map(spreadItem => ({
    ...spreadItem,
    imageUrl: "",
  })) ?? []
}

</script>