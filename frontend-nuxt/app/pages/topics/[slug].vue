<template>
  <div class="flex flex-col gap-7 pb-10">
    <div class="mx-auto sm:hidden w-full rounded-xl border border-orange-200 bg-orange-50 p-5 shadow-sm md:p-8">
      <div class="mb-3 flex items-center gap-2">
        <h1 class="text-3xl font-bold text-primary">
          {{ topic?.title ?? route.params.slug }}
        </h1>
        <component
          :is="getTopicIcon(String(route.params.slug))"
          v-if="getTopicIcon(String(route.params.slug))"
          class="h-10 w-10 shrink-0 text-primary"
          aria-hidden="true"
        />
      </div>
      <p class="text-md text-gray-600">
        {{ topic?.description }}
      </p>
    </div>

    <div class="hidden sm:flex gap-3 mx-auto w-full rounded-xl border border-orange-200 bg-orange-50 p-5 shadow-sm md:p-8">
      <component
        :is="getTopicIcon(String(route.params.slug))"
        v-if="getTopicIcon(String(route.params.slug))"
        class="h-20 w-20 shrink-0 text-primary"
        aria-hidden="true"
      />
      <div class="flex flex-col gap-1">
        <h1 class="text-3xl font-bold text-primary">
          {{ topic?.title ?? route.params.slug }}
        </h1>
        <p class="mt-3 text-md text-gray-600">
          {{ topic?.description }}
        </p>
      </div>
    </div>

    <div class="flex flex-col gap-4">
        <div
          v-for="question in topic?.questions ?? []"
          :key="question.slug"
          class="group rounded-xl border border-orange-200 bg-orange-50 hover:bg-orange-100 p-5 md:px-8 shadow-sm cursor-pointer"
          @click="askQuestion(question)"
        >
          <div class="flex items-center justify-between gap-4">
            <div class="flex min-w-0 flex-1 items-center">
              <p class="text-base font-medium leading-6 text-slate-700 md:text-lg">
                {{ question.text || question.slug }}
              </p>
            </div>

            <button
              type="button"
              class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary text-white transition group:bg-primary-hover group:shadow-md"
              :aria-label="`Ask question: ${question.text || question.slug}`"              
            >
              <ArrowRight class="h-5 w-5" />
            </button>
          </div>
        </div>
      </div>
  </div>
</template>

<script setup lang="ts">
import ArrowRight from '~/assets/icons/arrow-right.svg'
import type { Topic } from '~/types/Topic'

const iconModules = import.meta.glob(
  '~/assets/icons/topics/*.svg',
  {
    eager: true,
    import: 'default',
  },
)

function getTopicIcon(slug: string) {
  return iconModules[`/assets/icons/topics/${slug}.svg`]
}

definePageMeta({
  layout: 'payment'
})

const route = useRoute()
const router = useRouter()
const config = useRuntimeConfig()
const { locale } = useI18n()

const { data: topic, error } = await useFetch<Topic>(
  () => `/topics/${locale.value}/${route.params.slug}`,
  {
    baseURL: config.public.apiBase,
    key: () => `topic-${locale.value}-${String(route.params.slug)}`,
    watch: [locale, () => route.params.slug],
    server: false,
    transform: (value) => value as Topic,
  }
)

if (error.value) {
  throw createError({ statusCode: 404, statusMessage: 'Topic not found' })
}

useHead(() => ({
  title: topic.value?.seoTitle || topic.value?.title || String(route.params.slug),
  meta: [
    { name: 'description', content: topic.value?.seoDescription || topic.value?.description || '' },
    { property: 'og:title', content: topic.value?.seoTitle || topic.value?.title || String(route.params.slug) },
    { property: 'og:description', content: topic.value?.seoDescription || topic.value?.description || '' },
    { property: 'og:type', content: 'website' }
  ]
}))

function askQuestion(question: { slug: string, text: string | null }) {
  const sessionKey = 'question_to_card_query'
  const payload = {
    question: question.text || question.slug,
    topicSlug: route.params.slug,
    topicTitle: topic.value?.title || String(route.params.slug)
  }

  if (import.meta.client) {
    sessionStorage.setItem(sessionKey, JSON.stringify(payload))
  }

  router.push('/exercises/question-to-card')
}
</script>
