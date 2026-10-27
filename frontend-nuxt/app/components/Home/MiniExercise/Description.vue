<template>
    <div class="flex flex-col items-start">
        <span
          class="mb-3 inline-flex items-center rounded-full
                 bg-orange-100 px-3 py-1
                 text-xs font-semibold uppercase tracking-wider
                 text-orange-800"
        >
          Попробуйте прямо сейчас
        </span>

        <h2 class="text-2xl font-bold leading-tight text-slate-900">
          Мини-упражнение
        </h2>

        <p class="mt-3 text-sm leading-6 text-slate-600">
          Посмотрите на карту и ответьте на вопрос.
          Здесь нет правильных или неправильных ответов —
          важны ваши личные ассоциации.
        </p>

        <h3 class="mt-6 text-lg font-bold text-slate-900">
          Что вы видите на этой карте?
        </h3>

        <p class="mt-2 text-sm leading-6 text-slate-600">
          Какие чувства или мысли вызывает у вас этот образ?
        </p>

        <!-- Информационная плашка -->
        <p class="mt-3 flex items-center gap-2 text-sm leading-5 text-slate-700">
            <InfoIcon class="h-5 w-5 shrink-0 text-orange-600" />
            Ваша реакция на карту — подсказка для самопознания, а не оценка.
        </p>

        <!-- Короткое пояснение -->
        <p class="mt-3 flex items-center gap-2 text-sm leading-5 text-slate-700">
            <ClockIcon class="h-5 w-5 shrink-0 text-orange-600" />
            Это займёт меньше минуты и поможет лучше понять себя.
        </p>
    </div>
</template>

<script setup lang="ts">
import InfoIcon from '~/assets/icons/info.svg'
import ClockIcon from '~/assets/icons/clock.svg'
</script>