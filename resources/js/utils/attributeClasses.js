/**
 * @param {HTMElement} el
 * @param {string} attributeName
 */
export default function attributeClasses(el, attributeName) {
    return (el.getAttribute(attributeName) || "")
        .split(" ")
        .map((c) => c.trim())
        .filter(Boolean);
}
