<section class="grid grid-cols-1 lg:grid-cols-2 min-h-[75vh] relative overflow-hidden bg-[#fbfaf4]">

  {{-- Links — crème --}}
  <div class="relative z-10 flex flex-col justify-center px-8 lg:px-[12vw] py-20 bg-[#fbfaf4]">

    {{-- Eyebrow --}}
    <span class="inline-flex items-center gap-2 text-triv-pink text-xs font-bold tracking-[.14em] uppercase mb-6">
      VMBO TRIVIUM COLLEGE
    </span>

    {{-- Titel --}}
    <h1 class="text-5xl lg:text-6xl font-bold leading-[1.08] text-triv-blue mb-6">
      Maak jouw toekomst!
    </h1>

    {{-- Subtitel --}}
    <p class="text-[#7a6248] font-light leading-[1.78] max-w-sm mb-10">
      In ons onderwijs staat de leerling centraal. We helpen jou je talenten te ontdekken en te ontwikkelen, op jouw manier.
    </p>

    {{-- Buttons --}}
    <div class="flex flex-wrap gap-3 mb-10">
      <a href="#" class="inline-flex items-center gap-2 bg-triv-pink text-white font-semibold text-sm px-6 py-3 rounded-xl hover:bg-[#A63446] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
        Kom kennismaken
      </a>
      <a href="#" class="inline-flex items-center gap-2 bg-transparent text-triv-pink border-2 border-triv-pink font-semibold text-sm px-6 py-3 rounded-xl hover:bg-triv-pink hover:text-white hover:-translate-y-0.5 transition-all duration-200">
        Ontdek de drie werelden
      </a>
    </div>

    {{-- Stat pills --}}
    <div class="flex flex-wrap gap-3">
      <div class="inline-flex items-center gap-2 bg-white border border-[#f0e6d3] rounded-full px-4 py-2 text-xs font-semibold text-[#2b2318]">
        <span class="w-2 h-2 rounded-full bg-triv-red"></span>
        ~ 300 leerlingen
      </div>
      <div class="inline-flex items-center gap-2 bg-white border border-[#f0e6d3] rounded-full px-4 py-2 text-xs font-semibold text-[#2b2318]">
        <span class="w-2 h-2 rounded-full bg-triv-green"></span>
        3 werelden
      </div>
      <div class="inline-flex items-center gap-2 bg-white border border-[#f0e6d3] rounded-full px-4 py-2 text-xs font-semibold text-[#2b2318]">
        <span class="w-2 h-2 rounded-full bg-triv-yellow"></span>
        Max. 22 per klas
      </div>
    </div>
  </div>

  {{-- Rechts — foto's gestapeld --}}
  <div class="relative min-h-[400px] pt-2 pb-2 pl-4 pr-44 flex items-center">

    {{-- Foto wrapper voor stapel effect --}}
    <div class="relative w-full">

      {{-- Grote foto --}}
      <img src="{{ Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif') }}" alt="Leerlingen Trivium College" class="w-full max-h-[480px] object-cover rounded-br-[4rem] rounded-tl-[4rem] shadow-lg opacity-0 animate-[fadeInUp_.8s_.1s_ease_forwards]" />
      
      {{-- Kleine foto linksonder gestapeld --}}
      <div class="absolute -bottom-8 -left-30 z-10">
        <img src="{{ Vite::asset('resources/images/twee-jongens-aan-het-werk.avif') }}" alt="Leerlingen Trivium College" class="w-[300px] h-[220px] object-cover rounded-br-[2rem] rounded-tl-[2rem] border-4 border-[#fbfaf4] shadow opacity-0 animate-[fadeInUp_.8s_.4s_ease_forwards]" />
      </div>

      {{-- 94% badge --}}
      <div x-data="{ open: false }" @click="open = !open" class="absolute -top-10 right-0 z-20 cursor-pointer">
        <div :class="open ? 'w-[280px]' : 'w-[72px]'" class="relative bg-white rounded-tr-2xl rounded-tl-2xl rounded-bl-2xl rounded-br-none shadow flex items-center h-[72px] transition-all duration-500 ease-in-out overflow-hidden">
          {{-- Tekst --}}
          <div :class="open ? 'opacity-100 w-auto' : 'opacity-0 w-0'" class="transition-all duration-500 ease-in-out overflow-hidden whitespace-nowrap">
            <div class="text-[10px] font-bold uppercase tracking-widest pl-6">Dit schooljaar</div>
            <div class="text-xs leading-snug pl-6">is ons slagingspercentage</div>
          </div>

          {{-- Cirkel --}}
          <div class="w-[72px] h-[72px] flex-shrink-0 flex items-center justify-center bg-triv-lightblue rounded-tr-2xl rounded-tl-2xl rounded-bl-2xl rounded-br-none ml-auto">
            <span class="font-['Poppins'] text-2xl font-bold text-white leading-none">90%</span>
          </div>
        </div>
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
  <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ Vite::asset('resources/images/twee-meisjes-aan-het-bouwen.avif') }}');" ></div>

  <div class="absolute inset-0 bg-[#004289]/55"></div>

  <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
    <span class="text-xs font-bold tracking-[.18em] uppercase text-white/70 mb-4">
      Onze visie
    </span>
    <h2 class="text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
      De leerling <span class="text-[#fcbf00]">centraal</span>
    </h2>
    <p class="text-white font-light max-w-2xl leading-relaxed mb-8">
      We helpen onze leerlingen hun talenten te ontdekken, te ontwikkelen en te leren gebruiken. Want het gaat niet om de cijfers maar om wat je leert.
    </p>
    <a href="#" class="inline-flex items-center gap-2 bg-white text-[#004289] font-semibold text-sm px-8 py-3 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
      Lees onze visie →
    </a>
  </div>
</section>

{{-- ── DRIE WERELDEN SECTIE ── --}}
<section class="py-20 px-8 bg-[#fbfaf4]">
  <div class="max-w-[1280px] mx-auto">

    {{-- Header --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-end mb-8">
      <div>
        <span class="text-xs font-bold tracking-[.16em] uppercase text-[#e62733] flex items-center gap-2 mb-3 before:content-[''] before:w-5 before:h-[3px] before:bg-[#fcbf00] before:rounded-full">
          Onze school
        </span>
        <h2 class="text-5xl font-bold text-triv-blue leading-[1.05] mb-0">
          Onze drie werelden</em>
        </h2>
      </div>
      {{-- <div>
        <p class="text-[#7a6248] text-base leading-relaxed mb-4">
          Hoe je leert, is voor iedereen anders. We gaan samen op zoek naar de route die jou het best past en geven je ruimte om je eigen pad te kiezen.
        </p>
        <p class="text-[#7a6248] text-base leading-relaxed mb-6">
          In de onderbouw geven we je een stevige basis mee, met veel praktijkopdrachten en projecten. In de bovenbouw kies je voor een van onze profielen.
        </p>
        <a href="#" class="inline-flex items-center gap-2 bg-[#004289] text-white font-semibold text-sm px-6 py-3 rounded-full hover:-translate-y-0.5 hover:bg-[#3577bc] transition-all duration-200">
          Download profielkeuze boekje →
        </a>
      </div> --}}
    </div>

    {{-- Intro tekst --}}
    <div class="max-w-3xl mb-14">
      <p>
        In alles wat wij doen zijn we erop gericht dat jij met plezier naar school komt en leert. Je ontdekt waar jouw interesses en talenten liggen, waardoor je steeds beter weet waarom en waarvoor je leert.
        In vier jaar groei je uit tot een zelfbewuste, ondernemende jongere met een diploma. Jij weet waar je voor staat!
      </p>
    </div>

    {{-- Drie werelden kaarten --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      {{-- Wereld 1 — MVI --}}
      <a href="#" class="group bg-[#004289] rounded-3xl overflow-hidden flex flex-col hover:-translate-y-2 transition-transform duration-300 no-underline">
        {{-- Foto --}}
        <div class="h-56 overflow-hidden relative">
          <img
            src="{{ Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif') }}"
            alt="Wereld van ontwerpen"
            class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-[#004289] to-transparent"></div>
          {{-- Nummer --}}
          <div class="absolute top-4 left-4 w-9 h-9 bg-[#fcbf00] rounded-full flex items-center justify-center text-base font-black text-[#004289]">
            1
          </div>
        </div>
        {{-- Content --}}
        <div class="p-7 flex flex-col flex-1">
          <span class="text-[#fcbf00] text-xs font-bold uppercase tracking-widest mb-2">De wereld van ontwerpen</span>
          <h3 class="text-2xl font-bold text-white mb-4 leading-tight">
            Media, Vormgeving<br>&amp; ICT
            <span class="text-white/50 text-lg font-normal ml-1">[MVI]</span>
          </h3>
          {{-- Tags --}}
          <div class="flex flex-wrap gap-2 mb-6">
            @foreach(['Ontwerpen', 'Presenteren', 'Maken', 'Organiseren', 'Promoten'] as $tag)
              <span class="bg-white/10 text-white/80 text-xs font-medium px-3 py-1 rounded-full">{{ $tag }}</span>
            @endforeach
          </div>
          <div class="mt-auto flex items-center gap-2 text-[#fcbf00] font-bold text-sm group-hover:gap-3 transition-all duration-200">
            Ontdek deze wereld
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 5l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </a>

      {{-- Wereld 2 — D&P (iets omlaag) --}}
      <a href="#" class="group bg-[#56af31] rounded-3xl overflow-hidden flex flex-col hover:-translate-y-2 transition-transform duration-300 no-underline lg:mt-8">
        <div class="h-56 overflow-hidden relative">
          <img
            src="{{ Vite::asset('resources/images/twee-jongens-aan-het-werk.avif') }}"
            alt="Wereld van organiseren"
            class="w-full h-full object-cover opacity-75 group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-[#56af31] to-transparent"></div>
          <div class="absolute top-4 left-4 w-9 h-9 bg-white rounded-full flex items-center justify-center text-base font-black text-[#56af31]">
            2
          </div>
        </div>
        <div class="p-7 flex flex-col flex-1">
          <span class="text-white/60 text-xs font-bold uppercase tracking-widest mb-2">De wereld van organiseren</span>
          <h3 class="text-2xl font-bold text-white mb-4 leading-tight">
            Dienstverlening<br>&amp; Producten
            <span class="text-white/50 text-lg font-normal ml-1">[D&P]</span>
          </h3>
          <div class="flex flex-wrap gap-2 mb-6">
            @foreach(['Organiseren', 'Samenwerken', 'Flexibiliteit', 'Luisteren'] as $tag)
              <span class="bg-white/15 text-white/85 text-xs font-medium px-3 py-1 rounded-full">{{ $tag }}</span>
            @endforeach
          </div>
          <div class="mt-auto flex items-center gap-2 text-white font-bold text-sm group-hover:gap-3 transition-all duration-200">
            Ontdek deze wereld
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 5l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </a>

      {{-- Wereld 3 — E&O --}}
      <a href="#" class="group bg-[#fcbf00] rounded-3xl overflow-hidden flex flex-col hover:-translate-y-2 transition-transform duration-300 no-underline">
        <div class="h-56 overflow-hidden relative">
          <img
            src="{{ Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif') }}"
            alt="Wereld van zaken doen"
            class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-[#fcbf00] to-transparent"></div>
          <div class="absolute top-4 left-4 w-9 h-9 bg-[#004289] rounded-full flex items-center justify-center text-base font-black text-white">
            3
          </div>
        </div>
        <div class="p-7 flex flex-col flex-1">
          <span class="text-[#004289]/60 text-xs font-bold uppercase tracking-widest mb-2">De wereld van zaken doen</span>
          <h3 class="text-2xl font-bold text-white mb-4 leading-tight">
            Economie<br>&amp; Ondernemen
            <span class="text-[#004289]/40 text-lg font-normal ml-1">[E&O]</span>
          </h3>
          <div class="flex flex-wrap gap-2 mb-6">
            @foreach(['Retail & Styling', 'Service & Sales', 'Stock & Supplies'] as $tag)
              <span class="bg-[#004289]/10 text-[#004289]/80 text-xs font-medium px-3 py-1 rounded-full">{{ $tag }}</span>
            @endforeach
          </div>
          <div class="mt-auto flex items-center gap-2 text-[#004289] font-bold text-sm group-hover:gap-3 transition-all duration-200">
            Ontdek deze wereld
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 5l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </a>

    </div>

    {{-- Sluitende quote --}}
    <div class="mt-10 bg-white rounded-3xl p-8 flex flex-col lg:flex-row items-center justify-between gap-6 border border-slate-200">
      <p class="text-2xl max-w-xl leading-snug mb-0">
        "De samenleving van morgen heeft jou nodig.<br>Jij maakt de toekomst!"
      </p>
      <a href="#" class="inline-flex items-center gap-2 bg-[#fcbf00] text-[#004289] font-bold text-sm px-8 py-4 rounded-full whitespace-nowrap hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 shrink-0">
        Download profielkeuze boekje →
      </a>
    </div>

  </div>
</section>