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
      <div class="flex flex-col lg:flex-row gap-3">
        <button
            class="inline-flex items-center gap-2 rounded-md bg-primary hover:bg-primary-hover px-4 py-2 text-white font-medium shadow-md w-full md:w-fit justify-center"
            @click="isModalOpen = true"
        >
          {{ $t('add_resource') }}
        </button>
        <div class="flex items-center gap-4">

          <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="radio"
                value="open"
                v-model="resourceSelectionMode"
                class="accent-primary w-4 h-4"
            />
            <span class="text-gray-600">{{$t('open_mode')}}</span>
          </label>

          <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="radio"
                value="close"
                v-model="resourceSelectionMode"
                class="accent-primary w-4 h-4"
            />
            <span class="text-gray-600">{{$t('close_mode')}}</span>
          </label>

        </div>
      </div>
    </div>
  </div>
  <div ref="cardsContentRef" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
    <div v-for="(card, index) in cards" :key="cards.length" class="flex flex-col gap-3">
      <TurnCard
          v-model="cards[index]"
          :deck="cardDecks[index]"
          removable
          @remove="removeCardByIndex(index)"
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
  <BaseModal
      :open="isModalOpen"
      :h-full="resourceSelectionDeck !== ''"
      @close="isModalOpen = false; resourceSelectionDeck = ''"
  >
    <ChooseDeck
        v-if="resourceSelectionDeck === ''"
        v-model="resourceSelectionDeck"
        class="flex-1"
        :decks="decks"
        col-layout
        @update:modelValue="selectDeck()"
        />
    <CardSelection v-else-if="resourceSelectionDeck !== '' && resourceSelectionMode === 'open'" :deck="resourceSelectionDeck" @selected="(value) => selectCard(value)"/>

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
const isModalOpen = ref(false)
const resourceSelectionDeck = ref('')
const resourceSelectionMode = ref('open')
const query = ref('')
const error = ref('');
const intelligentHint = ref({});

const cards = ref([]);
const cardDecks = ref([]);

const cardsContentRef = ref(null);

function selectCard(value) {
  cards.value.push(value);
  cardDecks.value.push(resourceSelectionDeck.value);
  isModalOpen.value = false;
  resourceSelectionDeck.value = ''
}

function selectDeck() {
  if (resourceSelectionMode.value === 'close') {
    cards.value.push('');
    cardDecks.value.push(resourceSelectionDeck.value);
    isModalOpen.value = false;
    resourceSelectionDeck.value = ''
  }
}

function removeCardByIndex(index) {
  cards.value = cards.value.filter((_, i) => i !== index)
  cardDecks.value = cardDecks.value.filter((_, i) => i !== index)
}

function hasEmptyCards() {
  return cards.value.some((card) => !card)
}

async function getIntelligentHint() {
  error.value = ''

  if (!query.value || hasEmptyCards() || !cards.value.length) {
    error.value = $t('intelligent_hint_validation_all');
    return
  }

  try {
    loading.value = true;

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
      error.value = intelligentHint.value?.query_feedback;
    }

  } catch (errorResponse) {
    const responseData = errorResponse?.data ?? errorResponse?.response?._data

    if (responseData?.type === 'retryable_error') {
      error.value = $t('Something went wrong. Please, try again')
    } else {
      error.value = $t(`Something went wrong`)
    }
    console.log(errorResponse)
  } finally {
    loading.value = false;
  }
}
</script>