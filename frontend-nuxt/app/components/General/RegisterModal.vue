<template>
  <GeneralBaseModal
    :open="open"
    bg-class="bg-orange-50"
    width-class="sm:max-w-[420px]"
    @close="$emit('close')"
  >
    <template #header>
      <h3 class="text-xl font-bold text-gray-900">
        {{ $t('header.register') }}
      </h3>
    </template>

    <form class="w-full" @submit="onSubmit">
      <div class="space-y-4">
        <div>
          <label for="register-name" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.register.name') }}
          </label>
          <input
            id="register-name"
            v-model="name"
            type="text"
            class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 outline-none transition focus:bg-white"
            :class="isSubmitted && !!nameError ? 'border-red-300 focus:border-red-300' : 'focus:border-gray-500'"
            :placeholder="$t('auth.register.namePlaceholder')"
          />
          <p v-if="isSubmitted && nameError" class="mt-1 text-xs text-red-500">
            {{ nameError }}
          </p>
        </div>

        <div>
          <label for="register-email" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.general.email') }}
          </label>
          <input
            id="register-email"
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
          <label for="register-password" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.general.password') }}
          </label>
          <input
            id="register-password"
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

        <div>
          <label for="register-confirm-password" class="mb-1 block text-sm font-medium text-gray-700">
            {{ $t('auth.register.confirmPassword') }}
          </label>
          <input
            id="register-confirm-password"
            v-model="confirmPassword"
            type="password"
            class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 outline-none transition focus:bg-white"
            :class="isSubmitted && !!confirmPasswordError ? 'border-red-300 focus:border-red-300' : 'focus:border-gray-500'"
            :placeholder="$t('auth.register.confirmPasswordPlaceholder')"
          />
          <p v-if="isSubmitted && confirmPasswordError" class="mt-1 text-xs text-red-500">
            {{ confirmPasswordError }}
          </p>
        </div>
      </div>

      <button
        type="submit"
        class="mt-6 w-full rounded-lg bg-primary px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary-hover"
      >
        {{ $t('auth.register.submit') }}
      </button>
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
  (e: 'submit', value: { name: string; email: string; password: string }): void
}>()

const isSubmitted = ref(false)

const schema = yup.object({
  name: yup.string().required(t('auth.register.errors.nameRequired')).min(2, t('auth.register.errors.nameMin')),
  email: yup.string().required(t('auth.general.errors.emailRequired')).email(t('auth.general.errors.emailInvalid')),
  password: yup.string().required(t('auth.general.errors.passwordRequired')).min(8, t('auth.general.errors.passwordMin')),
  confirmPassword: yup
    .string()
    .required(t('auth.register.errors.confirmRequired'))
    .oneOf([yup.ref('password')], t('auth.register.errors.confirmMismatch')),
})

const { resetForm, validate } = useForm({
  validationSchema: schema,
  validateOnMount: false,
  initialValues: {
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
  },
})

const { value: name, errorMessage: nameError } = useField<string>('name')
const { value: email, errorMessage: emailError } = useField<string>('email')
const { value: password, errorMessage: passwordError } = useField<string>('password')
const { value: confirmPassword, errorMessage: confirmPasswordError } = useField<string>('confirmPassword')

const resetRegistrationForm = () => {
  isSubmitted.value = false

  resetForm({
    values: {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
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
    name: name.value,
    email: email.value,
    password: password.value,
  })
}

watch(
  () => props.open,
  (isOpen) => {
    if (isOpen) {
      resetRegistrationForm()
    }
  }
)
</script>
