<template>
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
</template>

<script setup>
defineProps({
  hint: {
    type: Object,
    required: true
  }
})
</script>