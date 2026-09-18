type QueryStatus = 'valid' | 'invalid' | 'unsafe'

export function useIntelligentAnalisis() {
  const config = useRuntimeConfig()
  const { t, locale} = useI18n()

  const loading = ref(false)
  const requestError = ref('')
  const isQueryUnsafe = ref(false)
  const intelligentAnalisisResult = ref<Record<string, any>>({})

  async function getIntelligentAnalisis(
    endpoint: string,
    body: object
  ) {
    requestError.value = ''
    isQueryUnsafe.value = false

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
        requestError.value = t('intelligent_analisis_invalid_query')
      }

      if (status === 'unsafe') {
        isQueryUnsafe.value = true
      }

      return intelligentAnalisisResult.value
    } catch (errorResponse: any) {
      const responseData =
        errorResponse?.data ??
        errorResponse?.response?._data

      if (responseData?.type === 'retryable_error') {
        requestError.value = 'Something went wrong. Please, try again'
      } else {
        requestError.value = 'Something went wrong'
      }

      console.log(errorResponse)

      return null
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    requestError,
    isQueryUnsafe,
    intelligentAnalisisResult,
    getIntelligentAnalisis
  }
}