<template>
    <BaseModal
        :open="!!modalMessage"
        :bg-class="backgroundClass"
        @close="$emit('close')"
    >
        <template #header>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ modalMessage?.title }}
            </h3>
        </template>

        <div class="flex items-center gap-4">
            <!-- Иконка -->
            <div
                class="flex h-[96px] w-[96px] shrink-0 items-center justify-center
                    rounded-full border-[6px]
                    text-4xl font-bold"
                :class="iconClass"
                aria-hidden="true"
            >
                {{ icon }}
            </div>

            <!-- Текст -->
            <p class="text-lg font-medium text-gray-800 dark:text-gray-400">
                {{ modalMessage?.message }}
            </p>
        </div>
    </BaseModal>
</template>

<script setup lang="ts">
const props = defineProps<{
    modalMessage: ModalMessage | null
}>()

defineEmits<{
    (e: 'close'): void
}>()

const backgroundClass = computed(() => {
    switch (props.modalMessage?.type) {
        case 'warning':
            return 'bg-orange-50'

        case 'error':
            return 'bg-red-50'

        case 'medical':
            return 'bg-white'

        case 'info':
        default:
            return 'bg-blue-50'
    }
})

const iconClass = computed(() => {
    switch (props.modalMessage?.type) {
        case 'warning':
            return 'border-orange-400 text-orange-400'

        case 'error':
            return 'border-red-400 text-red-400'

        case 'medical':
            return 'border-red-400 text-red-400'

        case 'info':
        default:
            return 'border-blue-400 text-blue-400'
    }
})

const icon = computed(() => {
    switch (props.modalMessage?.type) {
        case 'warning':
        case 'error':
            return '!'

        case 'medical':
            return '+'

        case 'info':
        default:
            return 'i'
    }
})
</script>