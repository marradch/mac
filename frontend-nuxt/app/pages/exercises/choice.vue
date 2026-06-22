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
      <div class="grid grid-cols-1" :class="{
        'grid-cols-1': numberOfCards !== 1,
        'grid-cols-1 sm:grid-cols-2 gap-3': numberOfCards === 1
      }">
        <div class="option-cards-container" v-for="i in 2"
             :key="i">
          <h2 class="text-3xl font-bold my-3 text-primary text-center">{{$t("variant")}} {{i}}</h2>
          <template v-if="numberOfCards === 1">
            <div class="card-container flex justify-center">
              <TurnCard :deck="deck" class="" v-model="cards[getOptionKey(i)][0]"/>
            </div>
          </template>
          <template v-if="numberOfCards === 3">
            <div class="cards-row-container grid grid-cols-1 sm:grid-cols-3 gap-3">
              <div class="card-container flex justify-center" :key="index" v-for="(n, index) in numberOfCards">
                <TurnCard :deck="deck" class="" v-model="cards[getOptionKey(i)][index]"/>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="fixed bottom-0 left-0 right-0 z-50 p-4 flex flex-col items-end gap-2">

        <ExerciseHintError :error="error" @close="error = ''"/>

        <ExerciseLoadingHintButton
            :loading="loading"
            @click="getIntelligentHint"
        />
      </div>
      <div ref="hintContentRef">
        <ChoiceHintResults :hint="intelligentHint" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const { t, locale} = useI18n()
const { exercise } = useExercise('choice')
const { decks, resetAvailableCardsState } = await useDecks()
const config = useRuntimeConfig()

const loading = ref(false)
const query = ref('')
const option1Text = ref('')
const option2Text = ref('')
const numberOfCards = ref(1)
const deck = ref(config.public.defaultDeckSlug)

type OptionKey = 'option_1' | 'option_2'
const options: OptionKey[] = ['option_1', 'option_2']

const cards = ref<Record<OptionKey, string[]>>({
  option_1: [''],
  option_2: [''],
})

const intelligentHint = ref({})
const hintContentRef = ref<HTMLElement | null>(null)
const error = ref('')

function hasEmptyCards() {
  return options.some((option: OptionKey) => {
    return cards.value[option].some((card) => !card)
  })
}

async function getIntelligentHint() {
  error.value = ''

  if (!query.value || !option1Text.value || !option2Text.value || hasEmptyCards()) {
    error.value = $t('intelligent_hint_validation_all')
    return
  }

  try {
    loading.value = true

    //const origin = useRequestURL().origin
    const origin = 'https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/'

    intelligentHint.value = await $fetch(`/choice/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        query: query.value,
        option1Text: option1Text.value,
        option2Text: option2Text.value,
        option1Cards: cards.value.option_1?.map(card => ({
          'imageUrl': origin + card
        })),
        option2Cards: cards.value.option_2?.map(card => ({
          'imageUrl': origin + card
        })),
      }
    })

    await nextTick()

    hintContentRef.value?.scrollIntoView({
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