<template>
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
</template>

<script setup>
defineProps({
  hint: {
    type: Object,
    required: true
  }
})
</script>