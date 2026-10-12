import './fonts'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import { initAnimatedText } from './animated-text'
import { initSlideSections } from './slide-sections'
import { initSteps } from './steps'

window.Alpine = Alpine

Alpine.plugin(intersect)
Alpine.plugin(collapse)
Alpine.plugin(focus)

Alpine.start()

initAnimatedText()
initSlideSections()
initSteps()

// iOS Safari past :active (en daarmee de hover-stijlen bij een tik, zie css/app.css) alleen toe als er een touch-listener is
document.addEventListener('touchstart', () => {}, { passive: true })
