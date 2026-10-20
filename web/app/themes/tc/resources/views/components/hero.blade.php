{{-- ── HERO — volledige breedte foto met tekst erop ── --}}
{{-- Trivium Settings > Hero: tekst en knop op mobiel verbergen (alleen de titel blijft) --}}
@php($verbergMobiel = function_exists('get_field') && get_field('hero_mobiel_verbergen', 'option'))
<section class="relative min-h-[95vh] overflow-hidden">

  {{-- Foto volledige breedte (onder de video); op mobiel iets naar links uitgesneden zodat het lachende meisje in beeld blijft --}}
  <img src="{{ Vite::asset('resources/images/leerlingen-aan-tafel-meisje-lacht.avif') }}" alt="Lachende leerling aan een tafel met klasgenoten van Trivium College"
    fetchpriority="high" decoding="async"
    class="absolute inset-0 w-full h-full object-cover object-[22%_0%] md:object-top"
  />

  {{-- Bovenbanner-video over de foto heen; de foto blijft zichtbaar tijdens het laden en bij "minder beweging" --}}
  <video autoplay muted loop playsinline preload="auto" aria-hidden="true"
    class="absolute inset-0 w-full h-full object-cover motion-reduce:hidden">
    <source src="{{ Vite::asset('resources/images/Trivium_Bovenbanner1.mp4') }}" type="video/mp4">
  </video>

  {{-- Overlay (mobiel van onder, onder de tekst; vanaf tablet van rechts) --}}
  <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-l from-black/70 md:from-black/60 via-black/30 to-transparent"></div>

  {{-- Extra donker rechtsboven op mobiel, zodat de witte header-iconen goed leesbaar zijn --}}
  <div class="md:hidden absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(0,0,0,0.55),transparent_55%)]"></div>

  {{-- Content: mobiel onderaan (anders valt de tekst over het gezicht op de foto), direct boven de golf van Leren met lef
       (die valt 4vh over de hero: 95 − 4 = 91vh, en de golf zelf nog 54px daarboven).
       Vanaf tablet rechts in de onderste helft: 7vh boven de golf. pt-20 houdt hem vrij van de header.
       Met alleen de titel op mobiel (Trivium Settings > Hero) staat hij iets hoger en over de volle breedte,
       want de SVG heeft geen eigen breedte en krimpt anders in. --}}
  <div @class(['relative z-10 min-h-[91vh] flex flex-col justify-end md:pt-20 md:pb-[7vh] items-end px-[6vw] 2xl:pr-52', $verbergMobiel ? 'pb-[14vh]' : 'pb-[54px]'])>
    <div @class(['max-w-[30rem]', 'max-md:w-full' => $verbergMobiel])>

      {{-- Titel (visueel verborgen, animated-text neemt de lettergrootte hiervan over) --}}
      <h1 class="sr-only text-5xl sm:text-6xl lg:text-7xl font-bold">Leren met Lef</h1>

      {{-- Geanimeerde titel --}}
      @include('components.animated-text')

      {{-- Subtitel --}}
      <p @class(['text-white font-light text-base leading-relaxed mb-3 md:mb-5 max-w-[38rem]', 'max-md:hidden' => $verbergMobiel])>
        Veel kiezen en doen en met elkaar heel veel uitproberen. Lef betekent dat je dit durft. Want we doen veel samen en helpen elkaar vooruit. We zijn een kleine school met vertrouwde docenten die er de hele dag voor je zijn. </p>

      {{-- Buttons --}}
      <div @class(['flex flex-wrap gap-3', 'max-md:hidden' => $verbergMobiel])>
        <x-button :href="App\page_url('onze-school')">Ontdek onze school</x-button>
      </div>
    </div>
  </div>
</section>
