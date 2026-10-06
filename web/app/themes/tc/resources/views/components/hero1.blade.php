{{-- ── HERO ── --}}
<section class="relative w-full overflow-hidden">
  <div class="rainbow"></div>
  {{-- Volledige breedte foto --}}
  <img
    src="{{ Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif') }}"
    alt="Leerlingen Trivium College"
    class="w-full h-[520px] object-cover object-[center_30%] block"
  />

  {{-- L-shape overlay --}}
  <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-start pt-12 px-8 pointer-events-none">
    <div class="max-w-[1280px] mx-auto w-full flex flex-col items-start">

      {{-- Blauw titel blok --}}
      <div class="bg-[#004289] rounded-t-[20px] rounded-br-[20px] px-10 pt-8 pb-7 max-w-[520px] pointer-events-auto">
        <h1 class="font-['Fraunces'] text-4xl lg:text-5xl font-black text-white leading-[1.1]">
          Maak <em class="italic text-[#fcbf00]">jouw</em><br>toekomst!
        </h1>
      </div>

      {{-- Wit content blok --}}
      <div class="bg-white rounded-b-[20px] rounded-tr-[20px] px-10 pt-8 pb-10 max-w-[520px] shadow-2xl pointer-events-auto">
        <p class="text-[#7a6248] font-light text-base leading-relaxed mb-7">
          In ons onderwijs staat de leerling centraal. We helpen jou je talenten te ontdekken, te ontwikkelen en te leren gebruiken — op jouw manier.
        </p>
        <div class="flex flex-wrap gap-3">
          <a href="#" class="inline-flex items-center gap-2 bg-[#004289] text-white font-semibold text-sm px-6 py-3 rounded-xl hover:bg-[#3577bc] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
            Kom kennismaken
          </a>
          <a href="#" class="inline-flex items-center gap-2 bg-transparent text-[#004289] border-2 border-[#004289] font-semibold text-sm px-6 py-3 rounded-xl hover:bg-[#004289] hover:text-white hover:-translate-y-0.5 transition-all duration-200">
            Ontdek de drie werelden
          </a>
        </div>
      </div>

    </div>
  </div>

  {{-- Stat pills rechtsonder --}}
  <div class="absolute bottom-6 right-8 flex flex-wrap gap-2 justify-end pointer-events-auto">
    <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm border border-white/60 rounded-full px-4 py-2 text-xs font-semibold text-[#1a1612]">
      <span class="w-2 h-2 rounded-full bg-[#004289]"></span>
      ~300 leerlingen
    </div>
    <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm border border-white/60 rounded-full px-4 py-2 text-xs font-semibold text-[#1a1612]">
      <span class="w-2 h-2 rounded-full bg-[#56af31]"></span>
      Max. 22 per klas
    </div>
    <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm border border-white/60 rounded-full px-4 py-2 text-xs font-semibold text-[#1a1612]">
      <span class="w-2 h-2 rounded-full bg-[#fcbf00]"></span>
      92% geslaagd
    </div>
  </div>

</section>