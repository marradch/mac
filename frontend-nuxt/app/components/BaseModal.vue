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
            class="relative z-10 w-full h-full max-h-screen lg:w-fit
                 bg-white p-3 lg:p-6 shadow-xl
                 lg:rounded-xl
                 overflow-y-auto flex flex-col"
            :class="hFull ? 'lg:max-h-[calc(100vh-40px)]' : 'lg:h-fit'"
        >
          <!-- Close button -->
          <button
              class="text-2xl absolute right-2 lg:right-4 top-2 lg:top-4 text-gray-500 hover:text-black"
              @click="$emit('close')"
          >
            ✕
          </button>

          <!-- HEADER -->
          <div v-if="$slots.header" class="mb-4 pb-2 lg:pb-4 text-xl font-bold text-gray-600 border-b border-gray-200">
            <slot name="header" />
          </div>

          <div class="flex-1 flex items-center justify-center h-[calc(100%-150px)]">
            <slot />
          </div>
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
  },
  hFull: {
    type: Boolean
  }
})

defineEmits(['close'])
</script>