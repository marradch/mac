<template>
  <div class="min-h-screen bg-white flex flex-col">

    <!-- Хедер с контейнером -->
    <header class="bg-primary shadow-sm border-b fixed top-0 left-0 right-0 z-50">
      <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
        <Header />
      </div>
    </header>

    <!-- Основной контент с контейнером -->
    <main class="flex-1 pt-9 md:pt-12">
      <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
        <slot />
      </div>
    </main>
  </div>
</template>