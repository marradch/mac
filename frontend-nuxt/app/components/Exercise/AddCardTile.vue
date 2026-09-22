<template>
    <div class="flex flex-col gap-3 items-center justify-start">
      <div class="w-full md:max-w-[400px]" :class="{ 'sm:mt-[80px]': hasMt }">
        <button
            type="button"
            class="w-full aspect-[2/3] rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-gray-400 transition flex items-center justify-center"
            @click="emit('click')"
        >
          <span
              class="text-[60px] text-gray-500"
          >
            +
          </span>
        </button>
      </div>
    </div>
</template>

<script setup lang="ts">
  const emit = defineEmits<{
    (e: 'click'): void
  }>()

  const props = withDefaults(defineProps<{
    hasMt?: boolean
  }>(), {
    hasMt: false
  })
</script>