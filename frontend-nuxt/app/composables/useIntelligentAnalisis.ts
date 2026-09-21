type QueryStatus = 'valid' | 'invalid' | 'unsafe'

export function useIntelligentAnalisis() {
  const config = useRuntimeConfig()
  const { t, locale} = useI18n()

  const loading = ref(false)
  const intelligentAnalisisResult = ref<Record<string, any>>({})
  const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()

  async function getIntelligentAnalisis(
    endpoint: string,
    body: object
  ) {
    try {
      loading.value = true

      intelligentAnalisisResult.value = await $fetch<Record<string, any>>(
        `/${endpoint}/${locale.value}`,
        {
          baseURL: config.public.apiBase,
          method: 'POST',
          body
        }
      )

      const status = intelligentAnalisisResult.value?.query_status

      if (status === 'invalid') {
        showModalMessage('warning', t('invalid_query_title'), t('invalid_query_message'))
      } else if (status === 'unsafe') {
        showModalMessage('error', t('unsafe_query_title'), t('unsafe_query_message'))
      } else if (status === 'medical') {
        showModalMessage('medical', t('medical_query_title'), t('medical_query_message'))
      }

      return intelligentAnalisisResult.value
    } catch (errorResponse: any) {
      const responseData =
        errorResponse?.data ??
        errorResponse?.response?._data

      if (responseData?.type === 'retryable_error') {
        showModalMessage('warning', t('retryable_error_title'), t('retryable_error_message'))
      } else {
        showModalMessage('error', t('error_title'), t('error_message'))
      }

      console.log(errorResponse)

      return null
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    intelligentAnalisisResult,
    getIntelligentAnalisis
  }
}