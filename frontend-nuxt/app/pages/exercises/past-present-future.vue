<template>
  <ExerciseHeader :exercise="exercise" />
  <div class="flex flex-1 flex-col lg:flex-row gap-[20px]">
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
      <div class="flex flex-col gap-3" :class="
        numberOfCards > 1
          ? ''
          : 'lg:flex-row'
      ">
        <div class="time-period-container flex-1" v-for="period in ['past', 'present', 'future']"
             :key="period">
          <h2 class="text-3xl font-bold mb-3 text-primary text-center">{{$t(period)}}</h2>
          <div class="card-container" :class="
            numberOfCards > 1
              ? 'grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-3'
              : 'flex justify-center'
          ">
            <TurnCard :deck="deck" class="" v-model="cards[period][i]" v-for="i in numberOfCards" :key="i"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const { t } = useI18n()
const { exercise } = useExercise('past-present-future')

const query = ref('')
const numberOfCards = ref(1)
const deck = ref('nature-reflections')
const cards = ref({
  past: [''],
  present: [''],
  future: ['']
})

watch(numberOfCards, (val) => {
  cards.value.past = Array(val).fill('')
  cards.value.present = Array(val).fill('')
  cards.value.future = Array(val).fill('')
})
</script>