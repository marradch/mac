<template>
  <div class="grid gap-3" :class="colLayout ? '' : 'sm:grid-cols-3'">
    <button
        v-for="deck in decks"
        :key="deck.slug"
        @click="$emit('update:modelValue', deck.slug)"
        class="
        flex items-center gap-3
        px-4 py-3 rounded-md
        transition-all duration-200
        shadow-md text-white
      "
        :class="
        modelValue === deck.slug
          ? 'bg-primary-hover'
          : 'bg-primary'
      "
    >
      <img
          :src="`/decks/${deck.slug}/icon.png`"
          :alt="deck.title"
          class="w-7 h-7 object-contain shrink-0"
      >

      <span class="font-medium">
    {{ deck.title }}
  </span>
    </button>
  </div>
</template>

<script setup lang="ts">
import type { Deck } from '~/types/Deck'

const props = defineProps<{
  decks?: Deck[]
  modelValue: string
  colLayout?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>