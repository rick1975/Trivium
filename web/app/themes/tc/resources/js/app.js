import './fonts'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import { initAnimatedText } from './animated-text'
import { initSlideSections } from './slide-sections'
import { initSteps } from './steps'
import { initDetails } from './details'
import { initReveal } from './reveal'
import { initHeroFeatures } from './hero-features'
import { registerSearchPanel } from './search-panel'

window.Alpine = Alpine

Alpine.plugin(intersect)
Alpine.plugin(collapse)
Alpine.plugin(focus)
registerSearchPanel(Alpine)

Alpine.start()

initAnimatedText()
initSlideSections()
initSteps()
initDetails()
initReveal()
initHeroFeatures()

// iOS Safari past :active (en daarmee de hover-stijlen bij een tik, zie css/app.css) alleen toe als er een touch-listener is
document.addEventListener('touchstart', () => {}, { passive: true })
