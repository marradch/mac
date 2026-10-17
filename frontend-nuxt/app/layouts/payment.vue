<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">
    <GeneralHeader />

    <main class="flex-1 pt-20 md:pt-24">
      <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
        <div class="flex flex-col gap-6 lg:flex-row">
          <aside class="order-2 flex flex-col gap-5 md:flex-row lg:order-1 lg:flex-1 lg:flex-col">
            <HomeHowItWorks class="md:flex-1 lg:flex-none" />
            <HomeProPayment class="md:flex-1 lg:flex-none" />
          </aside>

          <section class="order-1 lg:order-2 lg:flex-[3]">
            <slot />
          </section>
        </div>
      </div>
    </main>

    <GeneralFooter />
  </div>
</template>
