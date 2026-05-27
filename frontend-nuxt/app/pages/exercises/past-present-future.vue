<template>
  <ExerciseHeader :exercise="exercise" />
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px]">
      <ChooseDeck v-model="deck"/>
      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
      <div class="flex flex-col md:flex-row gap-3 items-center">
        <div class="text-start text-gray-600">{{$t('cards-number-per-time-period')}}</div>
        <div class="w-full md:w-[100px]">
          <select v-model.number="numberOfCards" class="w-full px-2 py-1 border rounded">
            <option value="1">1</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
      <div class="grid grid-cols-1" :class="{
        'grid-cols-1': numberOfCards !== 1,
        'grid-cols-1 sm:grid-cols-3': numberOfCards === 1
      }">
        <div class="time-period-container" v-for="period in ['past', 'present', 'future']"
             :key="period">
          <h2 class="text-3xl font-bold mb-3 text-primary text-center">{{$t(period)}}</h2>
          <template v-if="numberOfCards === 1">
            <div class="card-container flex justify-center">
                <TurnCard :deck="deck" class="" v-model="cards[period][0]"/>
            </div>
          </template>
          <template v-if="numberOfCards === 3">
            <div class="cards-row-container grid grid-cols-1 sm:grid-cols-3">
              <div class="card-container flex justify-center" :key="index" v-for="(n, index) in numberOfCards">
                <TurnCard :deck="deck" class="" v-model="cards[period][index]"/>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="fixed bottom-0 left-0 right-0 z-50 p-4 flex justify-end">
        <div class="fixed bottom-0 left-0 right-0 z-50 p-4 flex flex-col items-end gap-2">

          <div
              v-if="showIntelligentHintValidation"
              class="relative bg-primary text-white shadow-md rounded-md px-3 py-2 max-w-sm w-full md:w-fit"
          >
            <button
                class="absolute top-2 right-2 text-white hover:text-gray-600"
                @click="showIntelligentHintValidation = false"
                type="button"
            >
              ✕
            </button>

            <div class="pr-6">
              {{$t('intelligent_hint_validation_all')}}
            </div>
          </div>

          <ExerciseLoadingHintButton
              :loading="loading"
              @click="getIntelligentHint"
          />
        </div>
      </div>
      <div ref="hintContentRef">
        <TimeSpreadHintResults :hint="intelligentHint" />
      </div>
    </div>
  </div>
</template>

<script setup>
const { t, locale} = useI18n()
const { exercise } = useExercise('past-present-future')
const config = useRuntimeConfig()

const loading = ref(false)
const query = ref('')
const numberOfCards = ref(1)
const deck = ref('nature-reflections')
const cards = ref({
  past: [''],
  present: [''],
  future: ['']
})
const showIntelligentHintValidation = ref(false)
const intelligentHint = ref({});
const hintContentRef = ref(null);

function hasEmptyCards() {
  return ['past', 'present', 'future'].some((period) => {
    return cards.value[period].some((card) => !card)
  })
}

async function getIntelligentHint() {
  showIntelligentHintValidation.value = false

  if (!query.value || hasEmptyCards()) {
    showIntelligentHintValidation.value = true
    return
  }

  try {
    loading.value = true;

    const origin = useRequestURL().origin

    intelligentHint.value = await $fetch(`/time-spread/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        query: query.value,
        past: cards.value.past.map(card => ({
          'imageUrl': origin + card
        })),
        present: cards.value.past.map(card => ({
          'imageUrl': origin + card
        })),
        future: cards.value.past.map(card => ({
          'imageUrl': origin + card
        })),
      }
    })

    await nextTick()

    hintContentRef.value?.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })

  } catch (error) {
    console.error(error)

  } finally {
    loading.value = false;
  }

  watch(
      () => intelligentHint.value,
      async (val) => {
        if (!val || !Object.keys(val).length) return


      }
  )
}
</script>