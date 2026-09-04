<template>
  <div
      class="relative rounded-lg overflow-hidden shadow-md transition-all"
      :class="[borderClass, bgClass]"
  >
    <!-- Content container with max-height constraint -->
    <div
        class="relative transition-all duration-300"
        :style="{ maxHeight: isExpanded ? 'none' : `${maxHeight}px`, overflow: isExpanded ? 'visible' : 'hidden' }"
    >
      <!-- Blur overlay at bottom when collapsed -->
      <div
          v-if="!isExpanded && showBlur"
          class="absolute bottom-0 left-0 right-0 h-20 pointer-events-none"
          :style="{ 
            background: 'linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1))'
          }"
      />

      <!-- Content slot -->
      <div ref="contentRef" class="p-4 md:p-6">
        <slot />
      </div>
    </div>

    <!-- Toggle button -->
    <div class="flex items-center justify-center px-4 py-3 bg-white cursor-pointer transition"
         @click="toggleExpand"
    >
      <span class="text-sm font-medium text-gray-700 mr-2">
        {{ isExpanded ? t('show_less') : t('show_more') }}
      </span>
      <!-- Chevron icon -->
      <IconChevron :is-rotated="isExpanded" size="w-3 h-3 text-gray-600" />
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  maxHeight?: number
  bgClass?: string
  borderClass?: string
}

const props = withDefaults(defineProps<Props>(), {
  maxHeight: 200,
  bgClass: 'bg-white',
  borderClass: 'border border-gray-200'
})

const { t } = useI18n()

const isExpanded = ref(false)
const showBlur = ref(false)
const contentRef = ref<HTMLElement | null>(null)

const toggleExpand = () => {
  isExpanded.value = !isExpanded.value
}

onMounted(() => {
  // Check if content overflows to show blur
  if (contentRef.value) {
    showBlur.value = contentRef.value.scrollHeight > props.maxHeight
  }
})

watch(() => props.maxHeight, () => {
  if (contentRef.value) {
    showBlur.value = contentRef.value.scrollHeight > props.maxHeight
  }
})
</script>

<style scoped>
</style>
