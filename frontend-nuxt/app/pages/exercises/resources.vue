<template>
  <ExerciseHeader :exercise="exercise" />
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
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
    <div
        v-for="(card, index) in cards"
        :key="index"
        class="flex flex-col gap-3 items-center justify-start"
    >
      <div class="w-full md:max-w-[400px]">
        <TurnCard
            v-model="card.imageUrl"
            :deck="card.deck"
            manuallySelectable
            removable
            @remove="removeCardByIndex(index)"
        />

        <div ref="analisisContentRef">
          <ResourcesHintResults
              v-if="intelligentAnalisisResult?.analisis_results?.[index]"
              :hint="intelligentAnalisisResult?.analisis_results?.[index]"
          />
        </div>
      </div>
    </div>
    <AddCardTile @click="addCard" />
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
</template>

<script setup lang="ts">
const { t, locale} = useI18n()
const { exercise } = useExercise('resources')
const { decks } = await useDecks()

const config = useRuntimeConfig()
const deck = ref(config.public.defaultDeckSlug)


const query = ref('')
const { loading, intelligentAnalisisResult, getIntelligentAnalisis } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()

type CardWithDeck = {
  imageUrl: string
  deck: string
}
const cards = ref<CardWithDeck[]>([])

const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

function removeCardByIndex(index: number) {
  cards.value = cards.value.filter((_, i) => i !== index)
}

function hasEmptyCards() {
  return cards.value.some((card) => !card.imageUrl)
}

function addCard() {
  cards.value = [...cards.value, {
    imageUrl: '',
    deck: deck.value,
  }]
}

onMounted(() => {
  addCard()
})

async function getIntelligentAnalisisClick() {
  if (!query.value || hasEmptyCards() || !cards.value.length) {
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

  await nextTick()

  const firstHint = Array.isArray(analisisContentRef.value)
    ? analisisContentRef.value[0]
    : analisisContentRef.value

  if (intelligentAnalisisResult.value?.query_status === 'valid') {
    firstHint?.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  }
}
</script>