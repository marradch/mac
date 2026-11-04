export interface Topic {
  id?: number
  slug: string
  title?: string | null
  description?: string | null
  seoTitle?: string | null
  seoDescription?: string | null
  showOnHomepage?: boolean | null
  questions?: Array<{
    slug: string
    text: string | null
  }>
}