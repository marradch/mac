<template>
  <ExerciseHeader v-if="exercise" :exercise="exercise" />
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <ChooseDeck v-if="decks" :decks="decks" v-model="deck"/>

      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
    </div>
  </div>
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
    <div v-for="(card, index) in cards" :key="card.slug" class="flex flex-col gap-3 items-center">
      <p class="text-gray-600 text-center">{{ card.title }}</p>
      <TurnCard
          v-model="card.imageUrl"
          :deck="deck"
      ></TurnCard>
      <div v-if="intelligentHint?.cards_interpretations?.[index]?.interpretation" class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
        {{ intelligentHint.cards_interpretations[index].interpretation }}
      </div>

      <div v-if="intelligentHint?.cards_interpretations?.[index]?.affirmation" class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
        {{ intelligentHint.cards_interpretations[index].affirmation }}
      </div>
    </div>
  </div>
  <div class="fixed bottom-0 left-0 right-0 z-50 p-4 flex flex-col items-end gap-2">

    <ExerciseHintError :error="error" @close="error = ''"/>

    <ExerciseLoadingHintButton
        :loading="loading"
        @click="getIntelligentHint"
    />
  </div>
</template>
<script setup lang="ts">
import type { Exercise } from "~/types/Exercise"

const props = defineProps<{
  exercise: Exercise
}>()

const { t, locale} = useI18n()
const { decks, resetAvailableCardsState } = await useDecks()

const query = ref('')
const error = ref('')
const intelligentHint = ref({})
const config = useRuntimeConfig()
const deck = ref(config.public.defaultDeckSlug)

const cards = ref<Array<{
  slug: string
  title: string
  imageUrl: string
}>>([])

const cardsContentRef = ref(null)

cards.value = props.exercise?.spread?.map(spreadItem => ({
      ...spreadItem,
      imageUrl: "",
})) ?? []

watch(deck, () => {
  cards.value.forEach(card => (card.imageUrl = ''))
  resetAvailableCardsState()
})

function  getIntelligentHint() {
  console.log(cards.value, deck.value)
}

</script>