<template>
  <ExerciseHeader :exercise="exercise" />
  <div class="flex flex-1 flex-col md:flex-row gap-[20px]">
    <div class="flex-1 flex flex-col gap-[20px] justify-center">
      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
        <button
            class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-white font-medium shadow-md w-full md:w-fit justify-center"
            @click="isDeckModalOpen = true"
        >
          {{ $t('add_resource') }}
        </button>
    </div>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
    <TurnCard v-for="(card, index)  in cards" deck="nature-reflections" v-model="cards[index]"></TurnCard>
  </div>
  <div class="fixed bottom-0 left-0 right-0 z-50 p-4 flex flex-col items-end gap-2">

    <ExerciseHintError :error="error" @close="error = ''"/>

    <ExerciseLoadingHintButton
        :loading="loading"
        @click="getIntelligentHint"
    />
  </div>
  <BaseModal
      :open="isDeckModalOpen"
      @close="isDeckModalOpen = false; resourceSelectionDeck = ''"
  >
    <ChooseDeck :decks="decks" class="flex-1" v-if="resourceSelectionDeck === ''" v-model="resourceSelectionDeck"/>
    <CardSelection v-else :deck="resourceSelectionDeck" @selected="(value) => selectCard(value)"/>

    <template v-if="resourceSelectionDeck === ''" #header>
      {{ $t('choose_deck') }}
    </template>
    <template v-else #header>
      {{ $t('choose_card') }}
    </template>
  </BaseModal>
</template>

<script setup lang="ts">
const { t, locale} = useI18n()
const { exercise } = useExercise('resources')
const { decks } = await useDecks();
const config = useRuntimeConfig()
const loading = ref(false)
const isDeckModalOpen = ref(false)
const resourceSelectionDeck = ref('')

const cards = ref([]);

function selectCard(value) {
  cards.value.push(value);
  isDeckModalOpen.value = false;
  resourceSelectionDeck.value = ''
}
</script>