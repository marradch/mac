<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">

    <GeneralHeader />

    <!-- Основной контент с контейнером -->
    <main class="flex-1 pt-20 md:pt-24">
      <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
        <slot />
      </div>
    </main>

    <GeneralFooter />
  </div>
</template>