<template>
  <GeneralBaseModal
    :open="open"
    bg-class="bg-orange-50"
    width-class="sm:max-w-[420px]"
    @close="$emit('close')"
  >
    <template #header>
      <h3 class="text-xl font-bold text-gray-900">
        {{ $t('header.login') }}
      </h3>
    </template>

    <form class="w-full" @submit="onSubmit">
      <div class="space-y-4">
        <div>
          <label for="login-email" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.general.email') }}
          </label>
          <input
            id="login-email"
            v-model="email"
            type="email"
            class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 outline-none transition focus:bg-white"
            :class="isSubmitted && !!emailError ? 'border-red-300 focus:border-red-300' : 'focus:border-gray-500'"
            :placeholder="$t('auth.general.emailPlaceholder')"
          />
          <p v-if="isSubmitted && emailError" class="mt-1 text-xs text-red-500">
            {{ emailError }}
          </p>
        </div>

        <div>
          <label for="login-password" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.general.password') }}
          </label>
          <input
            id="login-password"
            v-model="password"
            type="password"
            class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 outline-none transition focus:bg-white"
            :class="isSubmitted && !!passwordError ? 'border-red-300 focus:border-red-300' : 'focus:border-gray-500'"
            :placeholder="$t('auth.general.passwordPlaceholder')"
          />
          <p v-if="isSubmitted && passwordError" class="mt-1 text-xs text-red-500">
            {{ passwordError }}
          </p>
        </div>
      </div>

      <button
        type="submit"
        class="mt-6 w-full rounded-lg bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary-hover"
      >
        {{ $t('auth.login.submit') }}
      </button>

      <div class="mt-4 text-center text-sm">
        <span class="text-gray-600">{{ $t('auth.login.noAccount') }}</span>
        <button
          type="button"
          class="ml-1 font-medium text-orange-700 transition hover:text-orange-800"
          @click="$emit('switch-to-register')"
        >
          {{ $t('auth.login.registerLink') }}
        </button>
      </div>
    </form>
  </GeneralBaseModal>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'

const props = defineProps<{
  open: boolean
}>()

const { t } = useI18n()

const emit = defineEmits<{
  (e: 'close'): void
  (e: 'submit', value: { email: string; password: string }): void
  (e: 'switch-to-register'): void
}>()

const isSubmitted = ref(false)

const schema = yup.object({
  email: yup.string().required(t('auth.general.errors.emailRequired')).email(t('auth.general.errors.emailInvalid')),
  password: yup.string().required(t('auth.general.errors.passwordRequired')).min(8, t('auth.general.errors.passwordMin')),
})

const { resetForm, validate } = useForm({
  validationSchema: schema,
  validateOnMount: false,
  initialValues: {
    email: '',
    password: '',
  },
})

const { value: email, errorMessage: emailError } = useField<string>('email')
const { value: password, errorMessage: passwordError } = useField<string>('password')

const resetLoginForm = () => {
  isSubmitted.value = false

  resetForm({
    values: {
      email: '',
      password: '',
    },
  })
}

const onSubmit = async (event: Event) => {
  event.preventDefault()

  isSubmitted.value = true

  const result = await validate()

  if (!result.valid) {
    return
  }

  emit('submit', {
    email: email.value,
    password: password.value,
  })
}

watch(
  () => props.open,
  (isOpen) => {
    if (isOpen) {
      resetLoginForm()
    }
  }
)
</script>
