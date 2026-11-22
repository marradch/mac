<template>
  <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-6">
    <NuxtLink
      v-for="topic in topics ?? []"
      :key="topic.slug"
      :to="`/topics/${topic.slug}`"
      class="flex flex-col items-center gap-2 rounded-xl shadow-sm p-5"
      :class="topicHoverColors[topic.slug] ?? ''"
    >
      <component
        :is="getTopicIcon(topic.slug)"
        v-if="getTopicIcon(topic.slug)"
        class="h-11 w-11 shrink-0"
      />

      <span class="font-medium text-center">{{ topic.title }}</span>
    </NuxtLink>
  </div>
</template>

<script setup lang="ts">
import type { Topic } from "~/types/Topic"

const props = withDefaults(defineProps<{
  forHome?: boolean
}>(), {
  forHome: false,
})

const iconModules = import.meta.glob(
  '~/assets/icons/topics/*.svg',
  {
    eager: true,
    import: 'default',
  },
)

const { locale } = useI18n()
const config = useRuntimeConfig()

const url = computed(() =>
  `/topics${props.forHome ? '-home' : ''}/${locale.value}`
)

const { data: topics, status, error } = await useFetch<Topic[]>(url, {
  baseURL: config.public.apiBase,
  key: () => `topics-${locale.value}-${props.forHome ? 'home' : 'all'}`,
  watch: [locale, () => props.forHome],
  getCachedData: (key) => {
    return useNuxtApp().payload.data[key]
  },
  server: false,
})

function getTopicIcon(slug: string) {
  return iconModules[`/assets/icons/topics/${slug}.svg`]
}

const topicHoverColors: Record<string, string> = {
  'anxiety': 'bg-indigo-50 hover:bg-indigo-100',
  'calling': 'bg-orange-50 hover:bg-orange-100',
  'finances': 'bg-emerald-50 hover:bg-emerald-100',
  'decisions': 'bg-teal-50 hover:bg-teal-100',
  'resources': 'bg-lime-50 hover:bg-lime-100',
  'self-knowledge': 'bg-purple-50 hover:bg-purple-100',
  'self-esteem': 'bg-violet-50 hover:bg-violet-100',
  'relationships': 'bg-rose-50 hover:bg-rose-100',
  'card-of-the-day': 'bg-pink-50 hover:bg-pink-100',
  'emotions': 'bg-amber-50 hover:bg-amber-100',
  'plans-and-goals': 'bg-sky-50 hover:bg-sky-100',
}
</script>
