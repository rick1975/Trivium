/**
 * Kenmerken-labels in de fotoheader "half" (components/page-hero, [data-hero-features]): zakken bij het scrollen
 * langzaam mee naar beneden, tot in het crème vlak onder de fotoheader (de bovenmarge van de inhoud). Via `transform`: de intro-animatie
 * (hero-rise) houdt `translate` vast en zou een inline translate overschrijven. Niet bij "minder beweging".
 */
export function initHeroFeatures() {
  const list = document.querySelector('[data-hero-features]')
  if (!list || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

  const speed = 0.5 // deel van de scrollafstand dat de labels meezakken
  const beyond = 40 // zover komt de onderkant van de labels onder de fotoheader uit (px)
  let max = 0
  let ticking = false

  // Met offsets (niet getBoundingClientRect), zodat de intro-animatie de meting niet beïnvloedt
  const measure = () => {
    if (!list.offsetParent) return // verborgen (onder md)
    max = Math.max(0, list.offsetParent.offsetHeight - list.offsetTop - list.offsetHeight + beyond)
    update()
  }

  const update = () => {
    ticking = false
    list.style.transform = `translateY(${Math.min(window.scrollY * speed, max)}px)`
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
