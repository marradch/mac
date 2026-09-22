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
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <textarea
            v-model="option1Text"
            :placeholder="$t('variant_1_placeholder')"
            class="w-full overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
        />
        <textarea
             v-model="option2Text"
             :placeholder="$t('variant_2_placeholder')"
             class="w-full overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
        />
      </div>
      <div class="flex flex-col md:flex-row gap-3 items-center">
        <div class="text-start text-gray-600">{{$t('cards-number-per-option')}}</div>
        <div class="w-full md:w-[100px]">
          <select v-model.number="numberOfCards" class="w-full px-2 py-1 border rounded">
            <option value="1">1</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
      <div class="grid grid-cols-1 mb-4" :class="{
        'grid-cols-1': numberOfCards !== 1,
        'grid-cols-1 sm:grid-cols-2 gap-3': numberOfCards === 1
      }">
        <div class="option-cards-container" v-for="i in 2"
              :key="i">
          <h2 class="text-3xl font-bold my-3 text-primary text-center">{{$t("variant")}} {{i}}</h2>
          <template v-if="numberOfCards === 1">
            <div class="card-container flex flex-col items-center justify-start">
              <TurnCard :deck="deck" class="" v-model="cards[getOptionKey(i)][0]"/>
              <div ref="analisisContentRef" class="scroll-mt-[100px]">
                <UsualCardHintResults v-if="intelligentAnalisisResult?.cards_analisis_results?.[getOptionKey(i)]?.[0]" :hint="intelligentAnalisisResult?.cards_analisis_results?.[getOptionKey(i)]?.[0]" />
              </div>
            </div>
          </template>
          <template v-if="numberOfCards === 3">
            <div class="cards-row-container grid grid-cols-1 sm:grid-cols-3 gap-3">
              <div class="card-container flex flex-col items-center justify-start" :key="index" v-for="(n, index) in numberOfCards">
                {{ getOptionKey(i) }}
                <TurnCard :deck="deck" class="" v-model="cards[getOptionKey(i)][index]"/>
                <div ref="analisisContentRef" class="scroll-mt-[100px]">  
                  <UsualCardHintResults v-if="intelligentAnalisisResult?.cards_analisis_results?.[getOptionKey(i)]?.[index]" :hint="intelligentAnalisisResult?.cards_analisis_results?.[getOptionKey(i)]?.[index]" />
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
      <ExerciseBottomActions
          :loading="loading"
          @hintButtonClick="getIntelligentHint"
      />
      <ChoiceHintResults :hint="intelligentAnalisisResult" />
      <MessageModal
          v-if="modalMessage"
          :modalMessage="modalMessage"
          @close="clearModalMessage"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
const { t, locale} = useI18n()
const { exercise } = useExercise('choice')
const { decks, resetAvailableCardsState } = await useDecks()
const config = useRuntimeConfig()

const query = ref('')
const option1Text = ref('')
const option2Text = ref('')
const numberOfCards = ref(1)
const deck = ref(config.public.defaultDeckSlug)

const { loading, intelligentAnalisisResult, getIntelligentAnalisis } = useIntelligentAnalisis()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()
const { isValidQuery } = useQueryValidation()

type OptionKey = 'option_1' | 'option_2'
const options: OptionKey[] = ['option_1', 'option_2']

const cards = ref<Record<OptionKey, string[]>>({
  option_1: [''],
  option_2: [''],
})

const analisisContentRef = ref<HTMLElement | HTMLElement[] | null>(null)

function hasEmptyCards() {
  return options.some((option: OptionKey) => {
    return cards.value[option].some((card) => !card)
  })
}

async function getIntelligentHint() {
  if (!isValidQuery(query.value) || !isValidQuery(option1Text.value) || !isValidQuery(option2Text.value) || hasEmptyCards()) {
    showModalMessage('warning', $t('invalid_input'), $t('intelligent_analisis_validation_all'))
    return
  }

  const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

  await getIntelligentAnalisis('choice', {
    query: query.value,
    option1Text: option1Text.value,
    option2Text: option2Text.value,
    option1Cards: cards.value.option_1?.map(card => ({
      'imageUrl': origin + card
    })),
    option2Cards: cards.value.option_2?.map(card => ({
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
  options.forEach((option) => {
    cards.value[option] = Array.from(
        { length: val },
        (_, i) => cards.value[option]?.[i] ?? ''
    )
  })
})

watch(deck, () => {
  cards.value = {
    option_1: Array(numberOfCards.value).fill(''),
    option_2: Array(numberOfCards.value).fill('')
  }
  resetAvailableCardsState()
})

const getOptionKey = (i: number): OptionKey =>
    `option_${i}` as OptionKey
</script>