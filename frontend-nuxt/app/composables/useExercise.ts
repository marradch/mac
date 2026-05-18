export const useExercise = (section: string) => {
    const { locale } = useI18n()
    const config = useRuntimeConfig()

    interface Exercise {
        title: string
        description: string
        seo_title: string
        seo_description: string
    }

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