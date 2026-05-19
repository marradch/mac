<template>
  <div class="mx-auto py-6 text-center">
    <h1 class="text-3xl font-bold mb-3 text-primary">
      {{ exercise?.title }}
    </h1>
    <p class="text-md text-gray-600">
      {{ exercise?.description }}
    </p>
  </div>
  <div class="flex flex-1 flex-col lg:flex-row gap-[20px] items-start">
    <TurnCard :deck="deck" class="order-2 lg:order-1 mb-[20px]" v-model="selectedCard"/>
    <div class="flex-1 order-1 lg:order-2 flex flex-col gap-[20px]">
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
      <button
          @click="getIntelligentHint"
          :disabled="loading"
          class="order-4 inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-white font-medium shadow-md w-full md:w-fit"
      >
        <span v-if="!loading">
          <span class="animate-pulse">✨</span>
          {{$t('intelligent_hint')}}
        </span>
        <span v-else class="flex items-center gap-2">
          <Icon class="animate-spin w-4 h-4"/>

          {{ loadingMessage }}
        </span>
      </button>
      <p v-if="showIntelligentHintValidation" class="order-5 font-bold mb-3 text-primary">
        {{ $t('intelligent_hint_validation') }}
      </p>
      <template v-if="intelligentHint?.is_query_valid">
        <div class="order-5">
          <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md flex items-center text-gray-600 mb-3">
            {{intelligentHint.interpretation}}
          </div>
          <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md flex items-center text-gray-600">
            {{ intelligentHint.reflection_through_card }}
          </div>
          <template v-if="intelligentHint.clarifying_questions.length">
            <h2 class="text-xl text-gray-600 py-3">{{$t('helpful_questions')}}</h2>
            <ul class="space-y-2 text-gray-600">
              <li
                  v-for="(question, i) in intelligentHint.clarifying_questions"
                  :key="i"
                  class="flex items-start gap-2"
              >
                <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
                <span>{{ question }}</span>
              </li>
            </ul>
          </template>

          <h2 class="text-xl text-gray-600 py-3">{{$t('affirmations')}}</h2>
          <ul class="space-y-2 text-gray-600 mb-3">
            <li
                v-for="(question, i) in intelligentHint.affirmations"
                :key="i"
                class="flex items-start gap-2"
            >
              <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
              <span>{{ question }}</span>
            </li>
          </ul>
        </div>
      </template>
      <template v-if="intelligentHint?.is_query_valid === false">
        <div class="order-5">
          <p class="font-bold mb-3 text-primary">
            {{ intelligentHint.query_feedback }}
          </p>
          <ul class="space-y-2 text-gray-600">
            <li
                v-for="(question, i) in intelligentHint.clarifying_questions"
                :key="i"
                class="flex items-start gap-2"
            >
              <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
              <span>{{ question }}</span>
            </li>
          </ul>
        </div>
      </template>
      <ChooseDeck class="lg:order-1" v-model="deck"/>
    </div>
  </div>
</template>

<script setup>
import Icon from '~/assets/icons/icon.svg'
const { t, locale } = useI18n()
const { exercise } = useExercise('question-to-card')
const config = useRuntimeConfig()

const query = ref('')
const selectedCard = ref('')
const showIntelligentHintValidation = ref(false)
const deck = ref('nature-reflections')

const pageTitle = computed(() => exercise.value?.seo_title ?? '')
const intelligentHint = ref({});

const loading = ref(false)

const loadingMessage = ref(t('intelligent_hint_loader.analyzing'))

const loadingMessages = [
  t('intelligent_hint_loader.analyzing'),
  t('intelligent_hint_loader.reading_symbols'),
  t('intelligent_hint_loader.finding_associations'),
  t('intelligent_hint_loader.forming_hint')
]

let interval = null

const startLoadingAnimation = () => {
  let index = 0

  loading.value = true
  loadingMessage.value = loadingMessages[0]

  interval = setInterval(() => {
    index = (index + 1) % loadingMessages.length
    loadingMessage.value = loadingMessages[index]
  }, 2000)
}

const stopLoadingAnimation = () => {
  clearInterval(interval)
  loading.value = false
}

async function getIntelligentHint() {
  showIntelligentHintValidation.value = false

  if (!query.value && !selectedCard.value) {
    showIntelligentHintValidation.value = true
    return
  }

  try {
    startLoadingAnimation()

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

    intelligentHint.value = {
      error: 'Не удалось получить подсказку. Попробуйте ещё раз.'
    }

  } finally {
    stopLoadingAnimation()
  }
}

useHead({
  title: pageTitle,
  meta: [
    { name: 'description', content: exercise.value?.seo_description },

    { property: 'og:title', content: exercise.value?.seo_title},
    { property: 'og:description', content: exercise.value?.seo_description},
    { property: 'og:type', content: 'website' }
  ]
})
</script>