<template>
  <ExerciseHeader :exercise="exercise" />
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
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 my-5">
    <div
        v-for="(card, index) in cards"
        :key="card.id"
        class="flex flex-col gap-3 items-center justify-start rounded-xl transition"
        :class="{
          'opacity-60': draggedIndex === index,
          'ring-2 ring-[#ff435d]/25 bg-[#ff435d0f] -translate-y-2': dragOverIndex === index,
        }"
        draggable="true"
        @dragstart="onDragStart(index, $event)"
        @dragover="onDragOver(index, $event)"
        @drop="onDrop(index, $event)"
        @dragend="onDragEnd"
    >
      <div class="w-full md:max-w-[400px]">
        <ExerciseTurnCard
            v-model="card.imageUrl"
            :deck="card.deck"
            manuallySelectable
            removable
            @remove="removeCardByIndex(index)"
        />

        <div ref="analisisContentRef" class="scroll-mt-[100px]">
          <HintResultsUsualCard
              v-if="intelligentAnalisisResult?.analisis_results?.[index]"
              :hint="intelligentAnalisisResult?.analisis_results?.[index]"
          />
        </div>
      </div>
    </div>
    <ExerciseAddCardTile @click="addCard" />
  </div>  
  <ExerciseBottomActions
      :loading="loading"
      @hintButtonClick="getIntelligentAnalisisConfirm"
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
  <HintResultsMeditation 
      v-if="intelligentAnalisisResult?.meditation" 
      :meditation="intelligentAnalisisResult?.meditation"
      class="mb-3"/>
</template>

<script setup lang="ts">
const { t } = useI18n()
const { exercise } = useExercise('resources')
const { decks } = await useDecks()

const config = useRuntimeConfig()
const deck = ref(config.public.defaultDeckSlug)
const isConfirmationModalOpen = ref(false)
const isQueryAndCardsActual = ref(true)
const isQueryActual = ref(true)
const shouldValidateQueryActuality = ref(false)


const query = ref('')
const { loading, intelligentAnalisisResult, getIntelligentAnalisis, isSuccessfull } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()
const { isValidQuery } = useQueryValidation()

type CardWithDeck = {
  id: string
  imageUrl: string
  deck: string
}
const cards = ref<CardWithDeck[]>([])
const draggedIndex = ref<number | null>(null)
const dragOverIndex = ref<number | null>(null)

const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

function removeCardByIndex(index: number) {
  cards.value = cards.value.filter((_, i) => i !== index)
}

function hasEmptyCards() {
  return cards.value.some((card) => !card.imageUrl)
}

function addCard() {
  cards.value = [...cards.value, {
    id: crypto.randomUUID(),
    imageUrl: '',
    deck: deck.value,
  }]

  if (intelligentAnalisisResult.value?.analisis_results) {
    intelligentAnalisisResult.value.analisis_results.push({})
  }
}

function onDragStart(index: number, event: DragEvent) {
  draggedIndex.value = index

  if (event.dataTransfer) {
    event.dataTransfer.effectAllowed = 'move'
    event.dataTransfer.setData('text/plain', String(index))
  }
}

function onDragOver(index: number, event: DragEvent) {
  event.preventDefault()

  if (draggedIndex.value !== null && draggedIndex.value !== index) {
    dragOverIndex.value = index
  }
}

function onDrop(index: number, event: DragEvent) {
  event.preventDefault()

  const fromIndex = draggedIndex.value

  if (fromIndex === null || fromIndex === index) {
    resetDrag()
    return
  }

  const updatedCards = [...cards.value]
  const [movedCard] = updatedCards.splice(fromIndex, 1)

  if (!movedCard) {
    resetDrag()
    return
  }

  updatedCards.splice(index, 0, movedCard)
  cards.value = updatedCards

  const analysisResults = intelligentAnalisisResult.value?.analisis_results

  if (Array.isArray(analysisResults)) {
    const updatedAnalysisResults = [...analysisResults]
    const [movedAnalysisResult] = updatedAnalysisResults.splice(fromIndex, 1)

    updatedAnalysisResults.splice(index, 0, movedAnalysisResult)
    intelligentAnalisisResult.value = {
      ...intelligentAnalisisResult.value,
      analisis_results: updatedAnalysisResults,
    }
  }

  resetDrag()
}

function onDragEnd() {
  resetDrag()
}

function resetDrag() {
  draggedIndex.value = null
  dragOverIndex.value = null
}

onMounted(() => {
  addCard()
})

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

function getIntelligentAnalisisConfirm() {
  if (shouldValidateQueryActuality.value && !isQueryActual.value) {
    showModalMessage('warning', t('dublicate_query'), t('dublicate_query_message'))
    return
  }
  if (!isQueryAndCardsActual.value) {
    showModalMessage('warning', t('dublicate_input'), t('dublicate_input_message'))
    return
  }
  if (!isValidQuery(query.value) || hasEmptyCards() || !cards.value.length) {
    showModalMessage('warning', t('invalid_input'), t('intelligent_analisis_validation_all'))
    return
  }
  isConfirmationModalOpen.value = true
}

async function getIntelligentAnalisisClick() {
  isConfirmationModalOpen.value = false

  if (!isValidQuery(query.value) || hasEmptyCards() || !cards.value.length) {
    showModalMessage('warning', $t('invalid_input'), $t('intelligent_analisis_validation_all'))
    return
  }

  const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

  await getIntelligentAnalisis('resources', {
    query: query.value,
    cards: cards.value.map(card => ({
      'imageUrl': origin + card.imageUrl
    })),
  })

  if (!isSuccessfull.value) {
    return
  }

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
</script>
