import './fonts'
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import collapse from '@alpinejs/collapse'
import { initAnimatedText } from './animated-text'

window.Alpine = Alpine

Alpine.plugin(intersect)
Alpine.plugin(collapse)

Alpine.start()

initAnimatedText()
