<template>
  <div v-if="hint?.is_query_valid === true" class="order-5 mt-3">
    <ExpandableCardBlock
        :max-height="600"
        bg-class="bg-orange-50"
        border-class="border border-orange-200"
    >
      <div class="space-y-4">
        <div v-if="hint.option1_interpretation" class="space-y-2">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">🖼️</span>
            {{ $t('variant') }} 1
          </h3>

          <p class="text-sm leading-relaxed text-gray-600">
            {{ hint.option1_interpretation }}
          </p>
        </div>

        <div v-if="hint.option2_interpretation" class="space-y-2">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">🖼️</span>
            {{ $t('variant') }} 2
          </h3>

          <p class="text-sm leading-relaxed text-gray-600">
            {{ hint.option2_interpretation }}
          </p>
        </div>

        <div v-if="hint.comparison" class="space-y-2 pt-2 border-t border-orange-200">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">⚖️</span>
            {{ $t('comparison') }}
          </h3>

          <p class="text-sm leading-relaxed text-gray-600">
            {{ hint.comparison }}
          </p>
        </div>

        <div v-if="hint.recommendations" class="space-y-2 pt-2 border-t border-orange-200">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">💡</span>
            {{ $t('recommendations') }}
          </h3>

          <p class="text-sm leading-relaxed text-gray-600">
            {{ hint.recommendations }}
          </p>
        </div>

        <div v-if="hint.clarifying_questions?.length" class="space-y-2 pt-2 border-t border-orange-200">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">🪞</span>
            {{ $t('helpful_questions') }}
          </h3>

          <ul class="space-y-1">
            <li
                v-for="(question, i) in hint.clarifying_questions"
                :key="i"
                class="flex items-start gap-2 text-sm text-gray-600"
            >
              <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-orange-400"></span>
              <span>{{ question }}</span>
            </li>
          </ul>
        </div>

        <div v-if="hint.affirmations?.length" class="space-y-2 pt-2 border-t border-orange-200">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">✨</span>
            {{ $t('affirmations') }}
          </h3>

          <ul class="space-y-1">
            <li
                v-for="(affirmation, i) in hint.affirmations"
                :key="i"
                class="flex items-start gap-2 text-sm text-gray-600"
            >
              <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-orange-400"></span>
              <span>{{ affirmation }}</span>
            </li>
          </ul>
        </div>
      </div>
    </ExpandableCardBlock>
  </div>

  <div v-else-if="hint?.is_query_valid === false" class="order-5">
    <WrongQuestionFeedback :hint="hint" />
  </div>
</template>

<script setup>
defineProps({
  hint: {
    type: Object,
    required: true
  }
})
</script>
