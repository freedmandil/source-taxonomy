// resources/js/utils/slugUtils.js

/**
 * Converts a string to a slug.
 * - Lowercases
 * - Removes punctuation (except spaces)
 * - Replaces spaces with underscores
 * @param {string} text
 * @returns {string}
 */
export function slugify(text) {
    return (text || '')
        .toLowerCase()
        .replace(/[^\w\s]|_/g, '')   // remove punctuation except whitespace
        .replace(/\s+/g, '_')        // replace spaces with underscores
        .trim()
}
