/**
 * Kenmerken-labels in de fotoheader "half" (components/page-hero, [data-hero-features]): zakken bij het scrollen
 * langzaam mee naar beneden, tot vlak boven de onderrand van de fotoheader. Via de losse CSS-eigenschap
 * `translate`, zodat de intro-animatie (transform) er niet mee botst. Niet bij "minder beweging".
 */
export function initHeroFeatures() {
  const list = document.querySelector('[data-hero-features]')
  if (!list || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

  const speed = 0.5 // deel van de scrollafstand dat de labels meezakken
  const gap = 16 // ruimte die onder de labels blijft (px)
  let max = 0
  let ticking = false

  // Met offsets (niet getBoundingClientRect), zodat de intro-animatie de meting niet beïnvloedt
  const measure = () => {
    max = Math.max(0, list.offsetParent.offsetHeight - list.offsetTop - list.offsetHeight - gap)
    update()
  }

  const update = () => {
    ticking = false
    list.style.translate = `0 ${Math.min(window.scrollY * speed, max)}px`
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      ticking = true
      requestAnimationFrame(update)
    }
  }, { passive: true })
  window.addEventListener('resize', measure)
  measure()
}
