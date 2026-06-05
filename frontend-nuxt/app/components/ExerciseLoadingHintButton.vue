<template>
  <button
      :disabled="loading"
      class="inline-flex items-center gap-2 rounded-md bg-primary hover:bg-primary-hover px-4 py-2 text-white font-medium shadow-md w-full md:w-fit justify-center"
      @click="emit('click')"
  >
    <span v-if="!loading">
      <span class="animate-pulse">✨</span>
      {{ $t('intelligent_hint') }}
    </span>

    <span v-else class="flex items-center gap-2">
      <Icon class="animate-spin w-4 h-4"/>
      {{ loadingMessage }}
    </span>
  </button>
</template>

<script setup>
const emit = defineEmits(['click'])

import Icon from '~/assets/icons/circle.svg'

const { t } = useI18n()

const props = defineProps({
  loading: Boolean
})

const loadingMessage = ref('')

const messages = [
  t('intelligent_hint_loader.analyzing'),
  t('intelligent_hint_loader.reading_symbols'),
  t('intelligent_hint_loader.finding_associations'),
  t('intelligent_hint_loader.forming_hint')
]

let interval = null

watch(
    () => props.loading,
    (value) => {
      clearInterval(interval)

      if (!value) return

      let index = 0
      loadingMessage.value = messages[0]

      interval = setInterval(() => {
        index = (index + 1) % messages.length
        loadingMessage.value = messages[index]
      }, 2000)
    },
    { immediate: true }
)

onUnmounted(() => clearInterval(interval))
</script>