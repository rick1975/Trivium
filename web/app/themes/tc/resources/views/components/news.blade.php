{{-- ── NIEUWS — de vier nieuwste berichten (data uit de News-composer) ── --}}
@if($newsItems)
  <section x-data x-intersect.once.margin.0.0.-30%.0="$el.dataset.shown = ''" class="group/nieuws overflow-x-clip pb-20 pt-10 bg-triv-cream lg:pb-32">
    <div class="page-container">

      {{-- Header. Vanaf md loopt op de hoogte van de kop een lijn vanaf de rechter schermrand naar links, met aan het eind
           het fruitlabel: gespiegelde versie van het label boven de footer (components/sitemap), in de kleuren van het
           crème vlak. Zodra het blok in beeld is (x-intersect zet data-shown; eigen groepsnaam group/nieuws, zodat de hover van de kaarten (group-hover) niet op de hele sectie reageert) groeit de lijn van rechts naar links, schuift
           het label in beeld en ploppen de fruiticoontjes na elkaar op en kleuren ze in (de omtrek wordt dan dunner en zacht navy). Mobiel: label onder de kop, zonder lijn. --}}
      <div class="relative mb-10 md:flex md:items-center">
        <h2 class="text-4xl md:text-5xl xl:text-6xl font-bold text-triv-pink mb-0">Nieuws</h2>
        <span aria-hidden="true" class="absolute top-1/2 left-[38%] -right-[calc((100vw-100%)/2)] hidden h-px origin-right scale-x-0 bg-linear-to-l from-triv-navy/15 via-triv-navy/15 via-80% to-transparent transition-transform duration-1000 ease-out group-data-shown/nieuws:scale-x-100 motion-reduce:scale-x-100 motion-reduce:transition-none md:block"></span>
        <p class="relative z-10 mt-4 mb-0 flex w-fit -translate-x-4 items-center gap-3 rounded-full border border-triv-navy/15 bg-triv-cream px-4 py-2 text-sm font-medium whitespace-nowrap text-triv-navy opacity-0 transition-[translate,opacity] delay-800 duration-500 ease-out group-data-shown/nieuws:translate-x-0 group-data-shown/nieuws:opacity-100 motion-reduce:translate-x-0 motion-reduce:opacity-100 motion-reduce:transition-none md:absolute md:top-1/2 md:left-[38%] md:mt-0 md:-translate-y-1/2 md:px-5 md:py-2.5 md:text-base">
          <span class="flex items-center gap-1" aria-hidden="true">
            @foreach(['apple', 'banana', 'watermelon'] as $fruit)
              <x-icon :name="$fruit" :size="32" class="h-6 w-auto md:h-8 text-triv-navy scale-0 transition-transform duration-400 ease-[cubic-bezier(.34,1.56,.64,1)] delay-[calc(1100ms+var(--i)*120ms)] group-data-shown/nieuws:scale-100 motion-reduce:scale-100 motion-reduce:transition-none [&_.fruit-fill]:opacity-0 [&_.fruit-fill]:transition-opacity [&_.fruit-fill]:duration-700 [&_.fruit-fill]:delay-[calc(2600ms+var(--i)*250ms)] group-data-shown/nieuws:[&_.fruit-fill]:opacity-100 motion-reduce:[&_.fruit-fill]:opacity-100 [&_.fruit-outline]:transition-[stroke-width,color] [&_.fruit-outline]:duration-700 [&_.fruit-outline]:delay-[calc(2600ms+var(--i)*250ms)] group-data-shown/nieuws:[&_.fruit-outline]:stroke-6 group-data-shown/nieuws:[&_.fruit-outline]:text-triv-navy/70 motion-reduce:[&_.fruit-outline]:stroke-6 motion-reduce:[&_.fruit-outline]:text-triv-navy/70" style="--i: {{ $loop->index }}" />
            @endforeach
          </span>
          Vers geplukt nieuws
        </p>
      </div>

      <x-news-featured :items="$newsItems">
        <x-button :href="$newsArchiveUrl" :dot="false">Alle berichten</x-button>
      </x-news-featured>
    </div>
  </section>
@endif
