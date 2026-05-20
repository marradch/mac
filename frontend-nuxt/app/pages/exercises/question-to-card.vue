<template>
  <ExerciseHeader :exercise="exercise" />
  <div class="flex flex-1 flex-col lg:flex-row gap-[20px] items-start">
    <TurnCard :deck="deck" class="order-2 lg:order-1 mb-[20px] mx-auto lg:mx-0" v-model="selectedCard"/>
    <div class="flex-1 w-full order-1 lg:order-2 flex flex-col gap-[20px]">
      <textarea
          v-model="query"
          :placeholder="$t('query_placeholder')"
          rows="1"
          class="order-2 lg:order-2 w-full min-h-[3cm] lg:min-h-[2cm] max-h-40 overflow-y-auto px-4 py-2 border rounded-lg resize-none shadow-sm"
      />
      <div class="order-1 lg:order-3 grid grid-cols-1 lg:grid-cols-3 gap-3">
        <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md flex items-center text-gray-600">
          {{$t("exercise_hint.description")}}
        </div>
        <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md flex items-center text-gray-600">
          {{ $t("exercise_hint.examples") }}
        </div>
        <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md flex items-center text-gray-600">
          {{ $t("exercise_hint.hint") }}
        </div>
      </div>
      <ExerciseLoadingHintButton
          :loading="loading" class="order-4" @click="getIntelligentHint"
      />
      <p v-if="showIntelligentHintValidation" class="order-5 font-bold mb-3 text-primary">
        {{ $t('intelligent_hint_validation') }}
      </p>
      <QuestionToCardHintResults :hint="intelligentHint"/>

      <ChooseDeck class="lg:order-1" v-model="deck"/>
    </div>
  </div>
</template>

<script setup>
const { t, locale } = useI18n()
const config = useRuntimeConfig()
const { exercise } = useExercise('question-to-card')

const query = ref('')
const selectedCard = ref('')
const showIntelligentHintValidation = ref(false)
const deck = ref('nature-reflections')
const intelligentHint = ref({});
const loading = ref(false)

async function getIntelligentHint() {
  showIntelligentHintValidation.value = false

  if (!query.value && !selectedCard.value) {
    showIntelligentHintValidation.value = true
    return
  }

  try {
    loading.value = true;

    intelligentHint.value = await $fetch(`/question/${locale.value}`, {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: {
        query: query.value,
        cardUrl: useRequestURL().origin + selectedCard.value
      }
    })

  } catch (error) {
    console.error(error)

  } finally {
    loading.value = false;
  }
}
</script>