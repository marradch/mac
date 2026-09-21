<template>
  <ExerciseHeader :exercise="exercise" />
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px]">
      <ChooseDeck :decks="decks" v-model="deck"/>
      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
      <div class="flex flex-col sm:flex-row gap-3 items-center">
        <div class="text-start text-gray-600">{{$t('cards-number')}}</div>
        <div class="w-full sm:w-[100px]">
          <select v-model.number="numberOfCards" class="w-full px-2 py-1 border rounded">
            <option value="1">1</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
      <div class="cards-container">
        <template v-if="numberOfCards === 1">
          <div class="card-container flex flex-col items-center justify-start">
            <TurnCard :deck="deck" class="" v-model="cards[0]" :key="0"/>
            <div ref="hintContentRef">
              <div ref="analisisContentRef" class="scroll-mt-[100px]">
              <UsualCardHintResults v-if="intelligentAnalisisResult?.analisis_results?.[0]" :hint="intelligentAnalisisResult?.analisis_results?.[0]" />
              </div>
            </div>
          </div>
        </template>
        <template v-if="numberOfCards === 3">
          <div class="cards-row-container grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="card-container flex flex-col items-center justify-start" :key="index" v-for="(n, index) in numberOfCards">
              <TurnCard :deck="deck" class="" v-model="cards[index]"/>
              <div ref="analisisContentRef" class="scroll-mt-[100px]">
              <UsualCardHintResults v-if="intelligentAnalisisResult?.analisis_results?.[index]" :hint="intelligentAnalisisResult?.analisis_results?.[index]" />
              </div>
            </div>
          </div>
        </template>
      </div>
      <ExerciseBottomActions
          :loading="loading"
          @hintButtonClick="getIntelligentAnalisisClick"
      />
      <MessageModal
          v-if="modalMessage"
          :modalMessage="modalMessage"
          @close="clearModalMessage"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
const { t } = useI18n()
const { exercise } = useExercise('question-to-card')
const { decks, resetAvailableCardsState } = await useDecks()
const config = useRuntimeConfig()

const query = ref('')
const numberOfCards = ref(1)
const deck = ref(config.public.defaultDeckSlug)
const cards = ref([''])

const { loading, intelligentAnalisisResult, getIntelligentAnalisis } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()
const { isValidQuery } = useQueryValidation()

const intelligentHint = ref<any>({})
const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

function hasEmptyCards() {
  return cards.value.some((card) => !card)
}

async function getIntelligentAnalisisClick() {
  if (!isValidQuery(query.value) || hasEmptyCards()) {
    showModalMessage('warning', $t('invalid_input'), $t('intelligent_analisis_validation_all'))
    return
  }

  const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

  await getIntelligentAnalisis('question', {
    query: query.value,
    cards: cards.value.map(card => ({
      'imageUrl': origin + card
    })),
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

watch(numberOfCards, (val) => {
  cards.value = Array.from(
      { length: val },
      (_, i) => cards.value?.[i] ?? ''
  )
})

watch(deck, () => {
  cards.value = Array(numberOfCards.value).fill('')
  resetAvailableCardsState()
})

</script>