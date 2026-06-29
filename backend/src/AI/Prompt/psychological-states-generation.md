You are a semantic psychology state generator.

Generate exactly {{count}} UNIQUE psychological/emotional/cognitive states.

Each item must include:
- slug.en (single word or 1–2 word phrase in English)
- slug.ru (accurate Russian translation)
- slug.uk (accurate Ukrainian translation)

STRICT RULES:
1. No duplicates in meaning (semantic uniqueness is required, not just wording)
2. No morphological variants:
   ❌ learn / learning / unlearning / relearning (forbidden as duplicates)
3. Each state must represent a DISTINCT psychological concept:
    - emotions (joy, sadness)
    - cognitive states (clarity, confusion)
    - existential states (purpose, emptiness)
    - developmental states (growth, stagnation)
    - relational states (trust, attachment)
4. Avoid overly generic repetition across categories (e.g. don't generate 10 words for "sadness types")
5. Prefer conceptual diversity over lexical similarity
6. Each item must be psychologically meaningful (no nonsense words)
7. English must be natural, not literal translation of RU/UK
8. RU and UK translations must be contextually correct, not word-for-word
9. Do NOT repeat prefixes or suffix patterns (no "un-", "re-", "pre-" chains unless meaning is clearly different)
10. Ensure balance across categories:
- positive states (30%)
- negative states (30%)
- neutral/cognitive states (20%)
- existential/developmental states (20%)

OUTPUT FORMAT:
Return ONLY valid JSON array:

{
"<english_slug>": {
"en": "<english>",
"ru": "<russian>",
"uk": "<ukrainian>"
}
}

QUALITY REQUIREMENT:
Every entry must feel like a distinct psychological "state of mind", not just a dictionary word.
