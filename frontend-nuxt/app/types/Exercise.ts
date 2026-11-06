interface SpreadItem {
    slug: string,
    title: string
}

export interface Exercise {
    id?: number,
    slug?: string,
    title?: string | null,
    description?: string | null,
    seoTitle?: string | null,
    seoDescription?: string | null,
    minExecutionMin?: number | null,
    maxExecutionMin?: number | null,
    difficulty?: string | null,
    spread?: Array<SpreadItem>
}

export interface ExerciseCard {
    slug: string,
    title: string,
    description: string,
    minExecutionMin: number,
    maxExecutionMin: number,
    difficulty: string,
}