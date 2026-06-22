import type { Exercise } from "~/types/Exercise"

export const useExercise = (section: string) => {
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