<template>
  <button
      :disabled="loading"
      class="inline-flex items-center gap-2 rounded-md bg-primary hover:bg-primary-hover px-4 py-2 text-white font-medium shadow-md w-full sm:w-fit justify-center"
      @click="emit('click')"
  >
    <span v-if="!loading">
      <span class="animate-pulse">✨</span>
      <slot></slot>
    </span>

    <span v-else class="flex items-center gap-2">
      <Icon class="animate-spin w-4 h-4"/>
      {{ loadingMessage }}
    </span>
  </button>
</template>

<script setup lang="ts">
import Icon from '~/assets/icons/circle.svg'

const emit = defineEmits<{
  click: []
}>()

const { t } = useI18n()

const props = defineProps<{
  loading: boolean
  messages?: string[]
}>()

const loadingMessage = ref<string|undefined>('')

let interval: ReturnType<typeof setInterval> | null = null

const messages = computed(() => props.messages ?? [
  t('intelligent_hint_loader.analyzing'),
  t('intelligent_hint_loader.reading_symbols'),
  t('intelligent_hint_loader.finding_associations'),
  t('intelligent_hint_loader.forming_result'),
])

watch(
  () => props.loading,
  (value) => {
    if (interval) {
      clearInterval(interval)
      interval = null
    }

    if (!value || !messages.value.length) {
      return
    }

    let index = 0
    loadingMessage.value = messages.value[0] ?? t('intelligent_hint_loader.forming_result')

    interval = setInterval(() => {
      index = (index + 1) % messages.value.length
      loadingMessage.value = messages.value[index]
    }, 2000)
  },
  { immediate: true }
)

onUnmounted(() => {
  if (interval) {
    clearInterval(interval)
  }
})
</script>