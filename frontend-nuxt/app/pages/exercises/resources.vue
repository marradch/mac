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

        <ResourcesHintResults
            v-if="intelligentHint?.analisis_results?.[index]"
            :hint="intelligentHint?.analisis_results?.[index]"
        />
      </div>
    </div>
    <AddCardTile @click="addCard" />
  </div>
  <ExerciseBottomActions
      :error="error"
      :loading="loading"
      @closeError="error = ''"
      @hintButtonClick="getIntelligentHint"
  />
</template>

<script setup lang="ts">
const { t, locale} = useI18n()
const { exercise } = useExercise('resources')
const { decks } = await useDecks()

const config = useRuntimeConfig()
const deck = ref(config.public.defaultDeckSlug)

const loading = ref(false)
const query = ref('')
const error = ref('')
const intelligentHint = ref<any>({})

type CardWithDeck = {
  imageUrl: string
  deck: string
}
const cards = ref<CardWithDeck[]>([])

const cardsContentRef = ref<HTMLElement | null>(null)

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

async function getIntelligentHint() {
  error.value = ''

  if (!query.value || hasEmptyCards() || !cards.value.length) {
    error.value = $t('intelligent_hint_validation_all')
    return
  }

  try {
    loading.value = true

    //const origin = useRequestURL().origin
    const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

    intelligentHint.value = await $fetch(`/resources/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        query: query.value,
        cards: cards.value.map(card => ({
          'imageUrl': origin + card
        })),
      }
    })

    await nextTick()

    if (intelligentHint.value?.is_query_valid) {
      cardsContentRef.value?.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      })
    } else {
      error.value = intelligentHint.value?.query_feedback
    }

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