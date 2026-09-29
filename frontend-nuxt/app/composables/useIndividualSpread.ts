export function useIndividualSpread() {
  const config = useRuntimeConfig()
  const { t, locale} = useI18n()

  const loadingIndividualSpread = ref(false)
  const intelligentAnalisisResult = ref<Record<string, any>>({})
  const { showModalMessage, modalMessage, clearModalMessage } = useModalMessage()

  interface IndividualSpreadItem {
    slug: string
    title: string
  }

  interface IndividualSpreadResponse {
    query_status: string
    spread?: IndividualSpreadItem[]
  }

  async function getIndividualSpread(
    query: string
  ) {
    try {
      loadingIndividualSpread.value = true

      const individualSpreadResult = await $fetch<IndividualSpreadResponse>(
        `/individual-spread/${locale.value}`,
        {
          baseURL: config.public.apiBase,
          method: 'POST',
          body: {
            query: query
          }
        }
      )

      const status = individualSpreadResult?.query_status

      if (status === 'invalid') {
        showModalMessage('warning', t('invalid_query_title'), t('invalid_query_message'))
      } else if (status === 'unsafe') {
        showModalMessage('error', t('unsafe_query_title'), t('unsafe_query_message'))
      } else if (status === 'medical') {
        showModalMessage('medical', t('medical_query_title'), t('medical_query_message'))
      }

      return individualSpreadResult
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
      loadingIndividualSpread.value = false
    }
  }

  return {
    loadingIndividualSpread,
    getIndividualSpread
  }
}