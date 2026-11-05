<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">
    <GeneralHeader />

    <main class="flex-1 pt-20 md:pt-24">
      <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
        <div class="flex flex-col gap-6" :class="layoutFlexClass">
          <aside class="order-2 flex flex-col gap-5 md:flex-row" :class="layoutAsideFlexClass">
            <HomeHowItWorks class="md:flex-1" :class="layoutChildrenClass"/>
            <HomeProPayment class="md:flex-1" :class="layoutChildrenClass"/>
          </aside>

          <section class="order-1 flex flex-col gap-5" :class="layoutSectionClass">
            <slot />
          </section>
        </div>
      </div>
    </main>

    <GeneralFooter />
  </div>
</template>

<script setup lang="ts">
const route = useRoute()

const layoutBreakpointIncrease = computed(() => {
  return route.meta.layoutLgBreakpointIncrease === true
})

const layoutFlexClass = computed(() => {
  return layoutBreakpointIncrease.value
    ? 'min-[1300px]:flex-row'
    : 'lg:flex-row'
})

const layoutAsideFlexClass = computed(() => {
  return route.meta.layoutLgBreakpointIncrease === true
    ? 'min-[1300px]:order-1 min-[1300px]:flex-1 min-[1300px]:flex-col'
    : 'lg:order-1 lg:flex-1 lg:flex-col'
})

const layoutChildrenClass = computed(() =>
  layoutBreakpointIncrease.value
    ? 'min-[1300px]:flex-none'
    : 'lg:flex-none'
)

const layoutSectionClass = computed(() =>
  layoutBreakpointIncrease.value
    ? 'min-[1300px]:order-2 min-[1300px]:flex-[3]'
    : 'lg:order-2 lg:flex-[3]'
)
</script>
