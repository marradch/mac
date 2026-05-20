<template>
  <div v-if="hint?.is_query_valid === true" class="order-5">

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.reflection_through_card }}
    </div>

    <template v-if="hint.clarifying_questions?.length">
      <h2 class="text-xl text-gray-600 py-3">
        {{ $t('helpful_questions') }}
      </h2>

      <ul class="space-y-2 text-gray-600">
        <li
            v-for="(question, i) in hint.clarifying_questions"
            :key="i"
            class="flex items-start gap-2"
        >
          <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
          <span>{{ question }}</span>
        </li>
      </ul>
    </template>

    <h2 class="text-xl text-gray-600 py-3">
      {{ $t('affirmations') }}
    </h2>

    <ul class="space-y-2 text-gray-600 mb-3">
      <li
          v-for="(item, i) in hint.affirmations"
          :key="i"
          class="flex items-start gap-2"
      >
        <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
        <span>{{ item }}</span>
      </li>
    </ul>
  </div>

  <div v-else-if="hint?.is_query_valid === false" class="order-5">

    <p class="font-bold mb-3 text-primary">
      {{ hint.query_feedback }}
    </p>

    <ul class="space-y-2 text-gray-600">
      <li
          v-for="(question, i) in hint.clarifying_questions"
          :key="i"
          class="flex items-start gap-2"
      >
        <span class="mt-2 h-2 w-2 rounded-full bg-primary shrink-0"></span>
        <span>{{ question }}</span>
      </li>
    </ul>

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