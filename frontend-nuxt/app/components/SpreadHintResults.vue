<template>
  <div v-if="hint" class="mt-3">
    <ExpandableCardBlock
        :max-height="250"
        bg-class="bg-orange-50"
        border-class="border border-orange-200"
    >
      <div class="space-y-4">
        <!-- Card interpretation -->
        <div v-if="hint.interpretation" class="space-y-2">
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">🖼️</span>
            {{$t('card_interpretation')}}
          </h3>

          <p class="text-gray-600 text-sm leading-relaxed">
            {{ hint.interpretation }}
          </p>
        </div>

        <!-- Affirmations -->
        <div
            v-if="hint.affirmations && hint.affirmations.length"
            class="space-y-2"
        >
          <h3 class="flex items-center gap-2 font-semibold text-gray-700">
            <span class="text-lg">✨</span>
            {{$t('affirmations')}}
          </h3>

          <ul class="space-y-1">
            <li
                v-for="(affirmation, index) in hint.affirmations"
                :key="index"
                class="flex items-start gap-2 text-sm text-gray-600"
            >
              <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-orange-400 shrink-0"></span>
              <span>{{ affirmation }}</span>
            </li>
          </ul>
        </div>

        <!-- Self reflection -->
        <div
            v-if="hint.selfReflectionQuestion"
            class="space-y-2 pt-2 border-t border-orange-200"
        >
          <h3 class="flex items-center gap-2 font-semibold text-gray-700 italic">
            <span class="text-lg not-italic">🪞</span>
            {{$t('self_reflection_question')}}
          </h3>

          <p class="text-gray-600 text-sm leading-relaxed">
            {{ hint.selfReflectionQuestion }}
          </p>
        </div>
      </div>
    </ExpandableCardBlock>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  hint?: any
}>()

const { t: $t } = useI18n()
</script>