import type { Deck } from "~/types/Deck"
export const useDecks = async () => {
    const availableCardsState = useState<Record<string, number[]>>(
        'availableCards',
        () => ({})
    )
    const decksState = useState<Deck[]>('decks', () => [])

    const { locale } = useI18n()
    const config = useRuntimeConfig()

    const { data: decks, status, error } = await useFetch<Deck[]>(
        () => `/decks/${locale.value}`,
        {
            baseURL: config.public.apiBase,
            key: () => `decks-${locale.value}`,
            watch: [locale],
            getCachedData: (key) => {
                return useNuxtApp().payload.data[key]
            },
        }
    )

    decksState.value = decks.value ?? []

    decks.value?.forEach(deck => {
        availableCardsState.value[deck.slug] = Array.from({ length: deck.cardsCount }, (_, i) => i + 1)
    })

    function resetAvailableCardsState() {
        decksState.value.forEach(deck => {
            availableCardsState.value[deck.slug] = Array.from({ length: deck.cardsCount }, (_, i) => i + 1)
        })
    }

    return {
        decks,
        resetAvailableCardsState,
        status,
        error
    }
}