import './fonts'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import { initAnimatedText } from './animated-text'
import { initSlideSections } from './slide-sections'

window.Alpine = Alpine

Alpine.plugin(intersect)
Alpine.plugin(collapse)
Alpine.plugin(focus)

Alpine.start()

initAnimatedText()
initSlideSections()
