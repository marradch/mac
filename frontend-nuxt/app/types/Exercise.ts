interface SpreadItem {
    slug: string,
    title: string
}

export interface Exercise {
    id?: number,
    slug?: string,
    title: string
    description: string
    seo_title: string
    seo_description: string,
    spread?: Array<SpreadItem>
}