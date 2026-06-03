<template>
  <Teleport to="body">
    <Transition
        enter-active-class="transition-opacity duration-200"
        leave-active-class="transition-opacity duration-200"
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
    >
      <div
          v-if="open"
          class="fixed inset-0 z-[999] flex items-end sm:items-center justify-center"
      >
        <!-- Overlay -->
        <div
            class="absolute inset-0 bg-black/50"
            @click="$emit('close')"
        />

        <!-- Modal -->
        <div
            class="relative z-10 w-full h-full sm:h-auto sm:max-w-3xl
                 bg-white p-6 shadow-xl
                 sm:rounded-xl
                 overflow-y-auto"
        >
          <!-- Close button -->
          <button
              class="absolute right-4 top-4 text-gray-500 hover:text-black"
              @click="$emit('close')"
          >
            ✕
          </button>

          <!-- HEADER -->
          <div v-if="$slots.header" class="mb-4 pb-4 text-xl font-bold text-gray-600 border-b border-gray-200">
            <slot name="header" />
          </div>

          <slot />
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  open: {
    type: Boolean,
    required: true
  }
})

defineEmits(['close'])
</script>