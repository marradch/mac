import type { Exercise } from "~/types/Exercise"
import type { AsyncDataRequestStatus } from '#app'

export const useExercise = (section: string): {
    exercise: Ref<Exercise | undefined>
    status: Ref<AsyncDataRequestStatus>
    error: Ref<Error | undefined>
} => {
    const { locale } = useI18n()
    const config = useRuntimeConfig()

    const { data: exercise, status, error } = useFetch<Exercise>(
        () => `/exercises/${locale.value}/${section}`,
        {
            baseURL: config.public.apiBase,
            watch: [locale]
        }
    )

    return {
        exercise,
        status,
        error
    }
}