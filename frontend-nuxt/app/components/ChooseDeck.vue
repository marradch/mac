<template>
<div class="grid md:grid-cols-3 gap-3">
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
const { locale } = useI18n()
const config = useRuntimeConfig()

const props = defineProps({
  modelValue: String
})

defineEmits(['update:modelValue'])

interface Deck {
  id: number
  slug: string
  title: string
  cardsCount: number
}

const availableCardsState = useState<[]>('availableCards', () => [])

const { data: decks } = await useFetch<Deck[]>(
    () => `/decks/${locale.value}`,
    {
      baseURL: config.public.apiBase,
      key: () => `decks-${locale.value}`,
      watch: [locale],
      getCachedData: (key) => {
        return useNuxtApp().payload.data[key]
      }
    }
)

watch(
    () => props.modelValue,
    (val) => {
      const cardsCount = decks.value.find(d => d.slug === val)?.cardsCount
      availableCardsState.value[val] = Array.from({ length: cardsCount }, (_, i) => i + 1)
    },
    { immediate: true }
)
</script>