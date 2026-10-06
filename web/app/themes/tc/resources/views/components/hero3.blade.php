{{-- ── HERO — 1/3 foto · 2/3 content ── --}}
<section class="grid grid-cols-[41%_59%]">

  {{-- Foto 1/3 --}}
  <div class="relative overflow-hidden">
    <img src="{{ Vite::asset('resources/images/Twee-dames-op-groene-achtergrond.avif') }}" alt="Leerlingen Trivium College" class="w-full h-full object-cover object-top">
  </div>

  {{-- Content 2/3 --}}
  <div class="relative bg-[#fbfaf4] flex flex-col justify-center px-[6vw] py-24">

    {{-- Nav rechtsboven --}}
    <div class="absolute top-0 left-0 right-0 flex items-center justify-end gap-6 px-[5vw] space-x-4 py-3 border-b border-t border-black/6 xl:pr-20">
        <a href="#" class="text-sm font-medium text-[#1a1612] hover:text-triv-orange transition-colors no-underline">Ons onderwijs</a>
        <a href="#" class="text-sm font-medium text-[#1a1612] hover:text-triv-orange transition-colors no-underline">Drie werelden</a>
        <a href="#" class="text-sm font-medium text-[#1a1612] hover:text-triv-orange transition-colors no-underline">Nieuws</a>
    </div>

    {{-- Eyebrow --}}
    <div class="flex items-center gap-2 text-[.68rem] font-bold tracking-[.18em] uppercase text-[#7a6248] mb-4 before:content-[''] before:w-[18px] before:h-[3px] before:bg-triv-yellow before:rounded-full">
      VMBO Trivium College
    </div>

    {{-- Titel --}}
    <h1 class="text-5xl lg:text-6xl font-bold text-triv-blue leading-[1.05] mb-5">
      Maak jouw <br>toekomst!
    </h1>

    {{-- Subtitel --}}
    <p class="text-[#7a6248] font-light text-base leading-relaxed max-w-lg mb-10">
      In ons onderwijs staat de leerling centraal. We helpen jou je talenten te ontdekken en te ontwikkelen, op jouw manier.
    </p>

    {{-- Buttons --}}
    <div class="flex flex-wrap gap-3 mb-12">
      <a href="#" class="inline-flex items-center gap-2 bg-triv-pink text-white font-semibold text-sm px-6 py-3 rounded-xl hover:bg-triv-pink hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 no-underline">
        Kom kennismaken
      </a>
      <a href="#" class="inline-flex items-center gap-2 bg-transparent text-triv-pink border-2 border-triv-pink font-semibold text-sm px-6 py-3 rounded-xl hover:bg-triv-pink hover:text-white hover:-translate-y-0.5 transition-all duration-200 no-underline">
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