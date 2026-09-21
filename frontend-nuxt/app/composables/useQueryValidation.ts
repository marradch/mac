export function useQueryValidation() {
  function isValidQuery(query: string): boolean {
    const value = query.trim()

    if (!value) {
      return false
    }

    if (value.length < 3) {
      return false
    }

    const characters = [...value]

    if (characters.every(char => char === characters[0])) {
      return false
    }

    return true
  }

  return {
    isValidQuery,
  }
}