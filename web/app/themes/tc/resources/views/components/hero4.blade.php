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
      <h1 class="sr-only">Leren met lef</h1>

      {{-- Geanimeerde titel --}}
      @include('components.animated-text')

      {{-- Subtitel --}}
      <p class="text-white font-light text-base leading-relaxed mb-8 max-w-[38rem] transition-all duration-700 delay-150" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
        veel kiezen en doen en met elkaar heel veel uitproberen. Lef betekent dat je dit durft. Want we doen veel samen en helpen elkaar vooruit. 
We zijn een kleine school met vertrouwde docenten die er de hele dag voor je zijn. 

      </p>

      {{-- Buttons --}}
      <div class="flex flex-wrap gap-3 mb-10 transition-all duration-700 delay-300" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
        <a href="#" class="inline-flex items-center gap-2 bg-triv-pink text-white font-semibold text-sm px-6 py-3 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 no-underline">
          Kom kennismaken
        </a>
      </div>

      {{-- Stat pills --}}
      {{-- <div class="flex flex-wrap gap-3 transition-all duration-700 delay-500" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-xs font-semibold text-white">
          <span class="w-2 h-2 rounded-full bg-triv-red"></span>
          ~ 300 leerlingen
        </div>
        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-xs font-semibold text-white">
          <span class="w-2 h-2 rounded-full bg-triv-green"></span>
          3 werelden
        </div>
        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-xs font-semibold text-white">
          <span class="w-2 h-2 rounded-full bg-triv-yellow"></span>
          Max. 22 per klas
        </div>
      </div> --}}
    </div>
  </div>
</section>

{{-- ── NIEUWS ── --}}

<div style="margin: -54px 0 0; position: relative; background: transparent;">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
    <path d="M0,0 Q720,80 1440,0 L1440,80 L0,80 Z" fill="#fbfaf4"/>
  </svg>
</div>
<section class="pb-20 pt-10 px-6 xl:px-20 bg-[#fbfaf4]">
  <div class="max-w-[1280px] mx-auto">

    {{-- Header --}}
    <div class="flex items-end justify-between mb-10">
      <div>
        <div class="flex items-center gap-2 text-[.68rem] font-bold tracking-[.18em] uppercase text-[#004289] mb-2 before:content-[''] before:w-[18px] before:h-[3px] before:bg-triv-yellow before:rounded-full">
          Actueel
        </div>
        <h2 class="text-4xl font-bold text-gray-800">Laatste nieuws</h2>
      </div>
      <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-triv-blue border-b-2 border-triv-yellow pb-0.5 no-underline hover:text-triv-pink transition-colors">
        Alle berichten →
      </a>
    </div>

    {{-- Magazine grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-6">

      {{-- Groot artikel links --}}
      <a href="#" class="group relative rounded-3xl overflow-hidden no-underline block min-h-[500px]">
        <img
          src="{{ Vite::asset('resources/images/Jongen-roert-in-pan.avif') }}"
          alt="Nieuws"
          class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 flex flex-col justify-end p-8">
          <div class="flex items-center gap-3 mb-3">
            <span class="bg-triv-pink text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Levensecht leren</span>
            <span class="text-white/60 text-xs">28 maart 2026</span>
          </div>
          <h3 class="text-2xl font-black text-white leading-snug mb-1 group-hover:text-triv-yellow transition-colors">
            Leerlingen koken voor echte gasten in ons schoolrestaurant
          </h3>
          <p class="text-white/70 text-xs my-1 leading-relaxed">
            Een driegangenmenu voor ouders en docenten. Levensecht leren in de keuken een avond om nooit te vergeten.
          </p>
        </div>
      </a>

      {{-- Twee kleine artikelen rechts --}}
      <div class="flex flex-col gap-6">

        {{-- Klein artikel 1 --}}
        <a href="#" class="group relative rounded-3xl overflow-hidden no-underline block flex-1 min-h-[235px]">
          <img
            src="{{ Vite::asset('resources/images/twee-jongens-aan-het-werk.avif') }}"
            alt="Nieuws"
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
          <div class="absolute inset-0 flex flex-col justify-end p-6">
            <div class="flex items-center gap-3 mb-2">
              <span class="bg-triv-blue text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Nieuws</span>
              <span class="text-white/60 text-xs">15 maart 2026</span>
            </div>
            <h3 class="text-base mb-1 font-black text-white leading-snug group-hover:text-triv-yellow transition-colors">
              Trivium wint regionale vakwedstrijd techniek
            </h3>
            <p class="text-white/70 text-xs my-1 leading-relaxed">
              Eerste prijs bij de regionale skills-wedstrijd!
            </p>
          </div>
        </a>

        {{-- Klein artikel 2 --}}
        <a href="#" class="group relative rounded-3xl overflow-hidden no-underline block flex-1 min-h-[235px]">
          <img
            src="{{ Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif') }}"
            alt="Nieuws"
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
          <div class="absolute inset-0 flex flex-col justify-end p-6">
            <div class="flex items-center gap-3 mb-2">
              <span class="bg-triv-yellow text-[#1a1612] text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Agenda</span>
              <span class="text-white/60 text-xs">5 maart 2026</span>
            </div>
            <h3 class="text-base mb-1 font-black text-white leading-snug group-hover:text-triv-yellow transition-colors">
              Open dag > 18 april > kom langs!
            </h3>
            <p class="text-white/70 text-xs my-1 leading-relaxed">
              Groep 8 leerlingen en ouders zijn van harte welkom.
            </p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ── WITTE BALK ── -->
<div class="bg-white border-b border-[#e8e0d0] py-20 px-8">
  <div class="max-w-[1280px] mx-auto grid grid-cols-[280px_1fr] gap-12 items-start">

    <!-- Gekleurde CTA blokken -->
    <div class="flex flex-col gap-3 max-w-[200px]">
      <a href="#" class="bg-[#fcbf00] rounded-2xl p-5 no-underline block hover:-translate-y-1 transition-transform duration-200">
        <h3 class="text-base font-bold text-gray-900 mb-1">Zit je in groep 8?</h3>
        <span class="text-xs font-semibold text-gray-900">→ Kijk dan snel hier</span>
      </a>
      <a href="#" class="bg-[#3577bc] rounded-2xl p-5 no-underline block hover:-translate-y-1 transition-transform duration-200">
        <h3 class="text-base font-bold text-white mb-1">Open dag 18 april</h3>
        <span class="text-xs font-semibold text-white/80">→ Meld je aan</span>
      </a>
    </div>

    <!-- Ga direct naar -->
    <div class="lg:mt-10">
      <h2 class="text-2xl font-bold mb-6">Ga direct naar:</h2>
      <div class="grid grid-cols-2 gap-x-10">

        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue group-hover:text-[#3577bc] transition-colors">→ Kom kennismaken</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Infoavonden &amp; open dagen</span>
        </a>
        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue group-hover:text-[#3577bc] transition-colors">→ Aanmelden</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Meld je aan bij onze school</span>
        </a>
        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue  group-hover:text-[#3577bc] transition-colors">→ Schoolgids</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Praktische informatie</span>
        </a>
        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue  group-hover:text-[#3577bc] transition-colors">→ Roosters</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Bekijk je rooster</span>
        </a>
        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue  group-hover:text-[#3577bc] transition-colors">→ Ziekmelden</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Snel en eenvoudig</span>
        </a>
        <a href="#" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
          <span class="font-bold text-triv-blue  group-hover:text-[#3577bc] transition-colors">→ De drie werelden</span>
          <span class="text-sm text-[#7a6248] mt-0.5">Ontdek jouw talent</span>
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Parallax foto sectie --}}
<section class="relative h-[600px] overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ Vite::asset('resources/images/Jongen-met-bokshandschoenen.avif') }}');" ></div>

  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
      Kleine school <br><span class="text-triv-yellow">grote betrokkenheid</span>
    </h2>
    <p class="text-white font-light max-w-2xl leading-relaxed mb-8">
      Het VMBO Trivium College is een kleine school met ongeveer 300 leerlingen en grote betrokkenheid bij haar leerlingen. De klassen zijn klein, meestal niet groter dat 22 leerlingen.
    </p>
    <a href="#" class="inline-flex items-center gap-2 bg-white text-[#004289] font-semibold text-sm px-8 py-3 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
      Lees meer
    </a>
  </div>
</section>

