interface SpreadItem {
    slug: string,
    title: string
}

export interface Exercise {
    title: string
    description: string
    seo_title: string
    seo_description: string,
    spread?: Array<SpreadItem>
}