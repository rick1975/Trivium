{{-- ── HERO — volledige breedte foto met tekst erop ── --}}
<section class="relative min-h-[95vh] overflow-hidden">

  {{-- Foto volledige breedte --}}
  <img src="{{ Vite::asset('resources/images/Jongen-roert-in-pan.avif') }}" alt="Leerlingen Trivium College"
    class="absolute inset-0 w-full h-full object-cover object-top"
  />

  {{-- Overlay --}}
  <div class="absolute inset-0 bg-gradient-to-l from-black/60 via-black/30 to-transparent"></div>
  
  {{-- Content --}}
  <div class="relative z-10 min-h-[85vh] flex flex-col justify-center 2xl:justify-end items-end px-[6vw] 2xl:pr-52 2xl:pb-24">
    <div class="max-w-[30rem]" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)">

      {{-- Titel (visueel verborgen, animated-text neemt de lettergrootte hiervan over) --}}
      <h1 class="sr-only text-5xl sm:text-6xl lg:text-7xl font-bold">Leren met lef</h1>

      {{-- Geanimeerde titel --}}
      @include('components.animated-text')

      {{-- Subtitel --}}
      <p class="text-white font-light text-base leading-relaxed mb-8 max-w-[38rem] transition-all duration-700 delay-150" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
        Veel kiezen en doen en met elkaar heel veel uitproberen. Lef betekent dat je dit durft. Want we doen veel samen en helpen elkaar vooruit. We zijn een kleine school met vertrouwde docenten die er de hele dag voor je zijn. </p>

      {{-- Buttons --}}
      <div class="flex flex-wrap gap-3 mb-8 transition-all duration-700 delay-300" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
        <a href="#" class="inline-flex items-center gap-2 bg-triv-pink text-white font-semibold text-sm px-6 py-3 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 no-underline">
          Ontdek onze school
        </a>
      </div>
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4'])

