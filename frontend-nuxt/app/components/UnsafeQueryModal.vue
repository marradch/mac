<template>
    <BaseModal :open="open" :h-full="hFull" @close="$emit('close')" :bg-class="'bg-red-50'">
        <template #header>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ $t('unsafe_query_modal_title') }}
            </h3>
        </template>

        <div class="mt-2 flex items-center gap-4">
            <!-- Иконка -->
            <div
                class="flex h-[96px] w-[96px] shrink-0 items-center justify-center
                    rounded-full border-[6px] border-red-400
                    text-4xl font-bold text-red-400"
                aria-hidden="true"
            >
                !
            </div>

            <!-- Текст -->
            <p class="text-lg font-medium text-gray-500 dark:text-gray-400">
                {{ $t('unsafe_query_modal_message') }}
            </p>
        </div>
    </BaseModal>
</template>
<script setup lang="ts">
defineProps<{
  open: boolean
  hFull?: boolean
}>()

defineEmits<{
  (e: 'close'): void
}>()
</script>