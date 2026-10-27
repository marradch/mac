<template>
  <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-6">
    <NuxtLink
      v-for="topic in topics ?? []"
      :key="topic.slug"
      :to="`/topics/${topic.slug}`"
      :class="`flex flex-col items-center gap-2 rounded-xl bg-white shadow-sm p-5 ${topicHoverColors[topic.slug] ?? ''}`"
    >
      <component
        :is="getTopicIcon(topic.slug)"
        v-if="getTopicIcon(topic.slug)"
        class="h-14 w-14 shrink-0"
      />

      <span class="font-medium text-center">{{ topic.title }}</span>
    </NuxtLink>
  </div>
</template>

<script setup lang="ts">
import type { Topic } from "~/types/Topic"
const iconModules = import.meta.glob(
  '~/assets/icons/topics/*.svg',
  {
    eager: true,
    import: 'default',
  },
)

const { locale, t } = useI18n()
const config = useRuntimeConfig()

const { data: topics, status, error } = await useFetch<Topic[]>(
    () => `/topics-home/${locale.value}`,
    {
        baseURL: config.public.apiBase,
        key: () => `topics-${locale.value}`,
        watch: [locale],
        getCachedData: (key) => {
            return useNuxtApp().payload.data[key]
        },
        server: false
    }
)

function getTopicIcon(slug: string) {
  return iconModules[`/assets/icons/topics/${slug}.svg`]
}

const topicHoverColors: Record<string, string> = {
  'finances': 'hover:bg-emerald-50',
  'self-esteem': 'hover:bg-violet-50',
  'relationships': 'hover:bg-rose-50',
  'card-of-the-day': 'hover:bg-pink-50',
  'emotions': 'hover:bg-amber-50',
  'plans-and-goals': 'hover:bg-sky-50',
}
</script>