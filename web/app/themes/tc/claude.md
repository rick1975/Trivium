# Project context

## Stack
- WordPress
- Sage 11 (Roots) met Bedrock
- Acorn v6 (Laravel integratie)
- Blade templates in `resources/views/`
- Tailwind CSS v4
- Vite v8 (via @roots/vite-plugin + laravel-vite-plugin)
- Alpine.js v3 + @alpinejs/intersect + @alpinejs/collapse
- Fonts zelf gehost via @fontsource (DM Sans + Poppins), geen Google Fonts
- PHP 8.3+
- Node >= 20

## Workflow
- Git via GitHub, na elke wijziging commit + push
- Package manager: npm (geen yarn)
- Build: `npm run build` / dev: `npm run dev`

## Conventies
- Blade templates voor alle views
- Herbruikbare UI als anonieme Blade-components in `resources/views/components/` (`<x-button>`, `<x-icon>`, `<x-logo>`, `<x-eyebrow>`, `<x-news-card>`, `<x-quick-links>`, `<x-parallax-banner>`)
- Voorpagina-blokken staan in `front-page.blade.php` (via `@section('before-main')` / `@section('after-main')`), niet in de layout
- Data voor views via View Composers in `app/View/Composers/`; gedeelde data (menu, contactgegevens) als singleton in `ThemeServiceProvider`
- Links naar pagina's via `App\page_url('slug')` (fallback `#` als de pagina niet bestaat)
- Controllers via Acorn
- Alpine.js v3 voor interactiviteit

## Git
- Nooit Co-Authored-By regels toevoegen aan commits
- Commit messages bevatten alleen een beschrijvende tekst, geen attributie metadata

## CSS & Styling
- Styling via Tailwind CSS v4
- Gebruik bij voorkeur `@apply` in plaats van inline utility classes
- CSS bestanden staan in `resources/css/` (hoofdbestand: `app.css`)
- Vóór een CSS fix: eerst diagnose uitleggen, geen bestanden aanpassen totdat bevestigd
- Na wijzigingen `npm run build` draaien om te controleren

## Instructies voor Claude
- Geef antwoorden in het Nederlands
- Houd rekening met de Sage/Bedrock structuur, geen standaard WordPress aanpak
- Geef alleen code als ik dat vraag, anders eerst uitleg
- Stel voor om te committen na afgeronde wijzigingen
## Livegang-checklist
- Alle testmateriaal verwijderen of vervangen door definitieve content, o.a.:
  - Testfoto's achtergrond Snelle links (`resources/images/jongen-achter-laptop.avif` (niet meer in gebruik), `resources/images/fotostudio-leerlingen.avif`, gebruikt in `resources/views/components/quick-links.blade.php`)
  - Foto fotoblok "Open dag 18 april" in Snelle links (`resources/images/jongen-met-krullen-laptop.avif`, als standaardfoto in `app/View/Composers/QuickLinks.php`; definitief via Trivium Settings > Snelle links een eigen foto kiezen)
  - Foto fotoblok "Zit je in groep 8?" in Snelle links (`resources/images/meisje-lacht-aan-tafel.avif`, als standaardfoto in `app/View/Composers/QuickLinks.php`; definitief via Trivium Settings > Snelle links een eigen foto kiezen)
