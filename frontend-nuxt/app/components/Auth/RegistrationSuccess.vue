<template>
  <section class="w-full bg-orange-50 text-center px-2 pb-2" aria-live="polite">
    <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-orange-100">
      <EmailIcon class="size-7 text-orange-700" aria-hidden="true" />
    </div>

    <p class="mt-5 text-lg font-semibold text-gray-900">
      {{ $t('auth.register.success.greeting', { name }) }}
    </p>
    <p class="mt-2 text-sm text-gray-600">
      {{ $t('auth.register.success.subtitle') }}
    </p>

    <div class="mt-5 rounded-lg bg-white px-4 py-5 shadow-sm">
      <p class="leading-6 text-gray-700">
        {{ $t('auth.register.success.confirmation') }}
      </p>
      <strong class="mt-3 block break-all text-base text-orange-700">{{ email }}</strong>
      <p class="mt-3 leading-6 text-gray-700">
        {{ $t('auth.register.success.confirmationSuffix') }}
      </p>
    </div>

    <p class="mt-5 leading-6 text-gray-600">
      {{ $t('auth.register.success.instructions') }}
    </p>

    <div class="mt-6 border-t border-orange-100 pt-6 text-center text-sm">
      <span class="text-gray-600">{{ $t('auth.register.success.noEmail') }}</span>
      <button type="button" class="ml-1 font-medium text-orange-700 transition hover:text-orange-800">
        {{ $t('auth.register.success.resend') }}
      </button>
    </div>
  </section>
</template>

<script setup lang="ts">
import EmailIcon from '~/assets/icons/email.svg'

defineProps<{
  name: string
  email: string
}>()
</script>
