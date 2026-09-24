<template>
  <div v-if="meditation && Array.isArray(meditation) && meditation.length > 0" class="mt-3">
    <GeneralExpandableCardBlock
        :max-height="250"
        bg-class="bg-orange-50"
        border-class="border border-orange-200"
    >
        <div
            class="space-y-2"
        >
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">✨</span>
            {{$t('meditation')}}
          </h3>

          <div class="space-y-2">
            <p v-for="(step, index) in meditation"
                :key="index"
                class="text-gray-600 text-sm leading-relaxed list-disc list-inside space-y-1">
              {{ step }}
            </p>
          </div>
        </div>
    </GeneralExpandableCardBlock>
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  meditation?: string[]
}>(), {
  meditation: () => ([])
})

const { t: $t } = useI18n()
</script>