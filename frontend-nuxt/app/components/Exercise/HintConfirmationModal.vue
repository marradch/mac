```vue
<template>
  <GeneralBaseModal
      :open="open"
      bg-class="bg-orange-50"
      width-class="sm:max-w-[600px]"
      @close="$emit('close')"
  >
    <template #header>
      <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
        {{ $t('ai_hint_confirmation_title') }}
      </h3>
    </template>

    <div class="flex flex-col items-center gap-6">
      <!-- Иконка и текст -->
      <div class="flex items-center gap-4">
        <!-- Иконка -->
        <div
            class="flex h-[96px] w-[96px] shrink-0 items-center justify-center
                rounded-full border-[6px]
                font-bold text-4xl border-orange-400 text-orange-400"
            aria-hidden="true"
        >
          !
        </div>

        <!-- Текст -->
        <p class="text-lg font-medium text-gray-800 dark:text-gray-400">
          {{ $t('ai_hint_confirmation_message') }}
        </p>
      </div>

      <!-- Confirm -->
      <button
          type="button"
          class="rounded-lg bg-orange-400 px-6 py-3
                 font-semibold text-white
                 transition hover:bg-orange-500"
          @click="$emit('confirm')"
      >
        {{ $t('confirm') }}
      </button>
    </div>
  </GeneralBaseModal>
</template>

<script setup lang="ts">
const { t } = useI18n()

defineProps<{
  open: boolean
}>()

defineEmits<{
  (e: 'close'): void
  (e: 'confirm'): void
}>()
</script>