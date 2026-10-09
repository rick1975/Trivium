{{-- ── HERO — volledige breedte foto met tekst erop ── --}}
<section class="relative min-h-[95vh] overflow-hidden">

  {{-- Foto volledige breedte; op mobiel iets naar links uitgesneden zodat het lachende meisje in beeld blijft --}}
  <img src="{{ Vite::asset('resources/images/leerlingen-aan-tafel-meisje-lacht.avif') }}" alt="Lachende leerling aan een tafel met klasgenoten van Trivium College"
    fetchpriority="high" decoding="async"
    class="absolute inset-0 w-full h-full object-cover object-[22%_0%] md:object-top"
  />

  {{-- Overlay (mobiel van onder, onder de tekst; vanaf tablet van rechts) --}}
  <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-l from-black/70 md:from-black/60 via-black/30 to-transparent"></div>

  {{-- Content: mobiel onderaan (anders valt de tekst over het gezicht op de foto), vanaf tablet rechts in het midden.
       Dat midden ligt tussen de header (pt-20 = 80px) en de golf van Leren met lef (die valt 8vh over de hero: 95 − 8 = 87vh) --}}
  <div class="relative z-10 min-h-[85vh] md:min-h-[87vh] flex flex-col justify-end pb-12 md:pt-20 md:pb-0 md:justify-center 2xl:justify-end items-end px-[6vw] 2xl:pr-52 2xl:pb-24">
    <div class="max-w-[30rem]">

      {{-- Titel (visueel verborgen, animated-text neemt de lettergrootte hiervan over) --}}
      <h1 class="sr-only text-5xl sm:text-6xl lg:text-7xl font-bold italic">Leren met Lef</h1>

      {{-- Geanimeerde titel --}}
      @include('components.animated-text')

      {{-- Subtitel --}}
      <p class="text-white font-light text-base leading-relaxed mb-8 max-w-[38rem]">
        Veel kiezen en doen en met elkaar heel veel uitproberen. Lef betekent dat je dit durft. Want we doen veel samen en helpen elkaar vooruit. We zijn een kleine school met vertrouwde docenten die er de hele dag voor je zijn. </p>

      {{-- Buttons --}}
      <div class="flex flex-wrap gap-3 mb-8">
        <x-button :href="App\page_url('onze-school')">Ontdek onze school</x-button>
      </div>
    </div>
  </div>
</section>
