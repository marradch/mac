<template>
  <div class="flex flex-col gap-3">
    <p class="mb-1 text-sm font-semibold text-slate-800">
      {{ t('home.mini_exercise.feeling_question') }}
    </p>

    <button
      v-for="answer in answers"
      :key="answer"
      type="button"
      :aria-pressed="selectedAnswers.includes(answer)"
      class="group flex min-h-12 items-center gap-3
             rounded-xl border px-4 py-3 text-left
             text-sm font-medium transition-all duration-200
             focus-visible:outline-none focus-visible:ring-2
             focus-visible:ring-orange-500 focus-visible:ring-offset-2"
      :class="
        selectedAnswers.includes(answer)
          ? 'border-orange-500 bg-orange-100 text-orange-900 shadow-sm'
          : 'border-orange-200 bg-white text-slate-700 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-900'
      "
      @click="toggleAnswer(answer)"
    >
      <span
        class="flex h-5 w-5 shrink-0 items-center justify-center
               rounded-full border transition-colors"
        :class="
          selectedAnswers.includes(answer)
            ? 'border-orange-500 bg-orange-500'
            : 'border-slate-300 bg-white group-hover:border-orange-400'
        "
      >
        <CheckIcon
          v-if="selectedAnswers.includes(answer)"
          class="h-3 w-3 text-white"
        />
      </span>

      <span>{{ answer }}</span>
    </button>
    <button
      type="button"
      class="mt-5 self-center md:self-start inline-flex min-h-11 items-center justify-center
             rounded-lg bg-primary px-6 py-3
             text-sm font-semibold text-white
             hover:bg-primary-hover"
      @click="submitAnswer"
    >
      {{ t('home.mini_exercise.submit') }}
    </button>
  </div>

  <GeneralMessageModal
    v-if="modalMessage"
    :modalMessage="modalMessage"
    @close="clearModalMessage"
  />
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import CheckIcon from '~/assets/icons/check.svg'

const { t } = useI18n()
const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()

const answers = computed(() => [
  t('home.mini_exercise.answers.freedom'),
  t('home.mini_exercise.answers.loneliness'),
  t('home.mini_exercise.answers.flight_dreams'),
  t('home.mini_exercise.answers.other'),
])

const selectedAnswers = ref<string[]>([])

const toggleAnswer = (answer: string) => {
  if (selectedAnswers.value.includes(answer)) {
    selectedAnswers.value = selectedAnswers.value.filter((item) => item !== answer)
  } else {
    selectedAnswers.value.push(answer)
  }
}

const submitAnswer = () => {
  if (selectedAnswers.value.length) {
    showModalMessage(
      'warning',
      t('home.mini_exercise.modal.success_title'),
      t('home.mini_exercise.modal.success_message'),
    )
  } else {
    showModalMessage(
      'warning',
      t('home.mini_exercise.modal.required_title'),
      t('home.mini_exercise.modal.required_message'),
    )
  }
}
</script>