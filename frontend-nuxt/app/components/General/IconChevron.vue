<template>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="8 4 9 16"
      stroke="currentColor"
      class="transition-transform duration-300"
      :class="[size, isRotated ? '-rotate-90' : 'rotate-90']"
  >
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 5l7 7-7 7"
    />
  </svg>
</template>

<script setup lang="ts">
interface Props {
  isRotated?: boolean
  size?: string
}

withDefaults(defineProps<Props>(), {
  isRotated: false,
  size: 'w-5 h-5'
})
</script>
