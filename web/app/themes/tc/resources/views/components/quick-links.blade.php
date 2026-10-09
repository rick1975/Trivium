{{-- ── SNELLE LINKS — fotoblokken en "Ga direct naar"-links uit Trivium Settings > Snelle links
     (Composers\QuickLinks), in de stijl van de fotobanner: grote titel met roze tweede regel, en kaarten met
     foto, donker verloop van onder, witte titel en roze chevron (zoals in het zoekpaneel). Bij hover zoomt de foto iets in.
     Mobiel alles onder elkaar, vanaf lg twee gelijke kolommen (fotokaarten dan ± 290 × 390 px). ── --}}
@if($links || $ctas)
<section class="relative overflow-hidden bg-white py-16 md:py-24 xl:py-32">
  {{-- Decoratieve rimpelingen vanuit een roze stip (verwijst naar de stip in het logo), rechtsboven verankerd;
       op smalle schermen niet kleiner dan 1000px en 400px naar rechts (stip buiten beeld, alleen de bogen). Bron: resources/images/shape-ripples.svg --}}
  <img src="{{ Vite::asset('resources/images/shape-ripples.svg') }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
    class="pointer-events-none absolute top-0 -right-[400px] md:right-0 w-full min-w-[1000px] max-w-none h-auto select-none">

  <div class="relative page-container grid gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:gap-16 xl:gap-24">

    {{-- Titel + fotoblokken (ook op mobiel naast elkaar) --}}
    <div>
      {{-- Zonder ingevulde titel toch een (onzichtbare) h2, zodat de h3's eronder niet los hangen --}}
      @if(! $title)
        <h2 class="sr-only">Snelle links</h2>
      @endif
      @if($title)
        <h2 class="text-5xl md:text-6xl xl:text-7xl font-bold text-triv-navy leading-[1.05] mb-10">
          {{ $title }}
          @if($highlight)
            <br><span class="text-triv-pink">{{ $highlight }}</span>
          @endif
        </h2>
      @endif
      <ul class="grid grid-cols-2 gap-4 mb-0">
        @foreach($ctas as $cta)
          <li class="mb-0"><a href="{{ $cta['url'] }}" class="group relative flex aspect-[3/4] items-end overflow-hidden rounded-xl no-underline">
            <img src="{{ $cta['image'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover transition-transform duration-500 group-hover:scale-105">
            <span class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent" aria-hidden="true"></span>
            <div class="relative z-10 p-4 sm:p-5">
              <h3 class="text-lg sm:text-2xl font-bold text-white leading-tight mb-2">{{ $cta['title'] }}</h3>
              <span class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-white/90">
                {{ $cta['text'] }}
                <x-icon name="chevron-right" class="size-3 shrink-0 text-triv-pink transition-transform duration-200 group-hover:translate-x-1.5" />
              </span>
            </div>
          </a></li>
        @endforeach
      </ul>
    </div>

    {{-- Ga direct naar-links (kop "Snelle links" alleen voor screenreaders) --}}
    <div class="lg:self-end">
      <h3 id="quick-links-direct" class="sr-only">Snelle links</h3>
      <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 mb-0" aria-labelledby="quick-links-direct">
        @foreach($links as $link)
          <li class="mb-0"><a href="{{ $link['url'] }}" class="group flex h-full items-center justify-between gap-4 py-5 border-b border-gray-100 no-underline">
            <span class="flex flex-col">
              <span class="text-xl font-bold text-triv-navy group-hover:text-triv-pink transition-colors">{{ $link['title'] }}</span>
              <span class="text-base text-gray-600 mt-1">{{ $link['text'] }}</span>
            </span>
            <x-icon name="chevron-right" class="size-4 shrink-0 text-triv-pink transition-transform duration-200 group-hover:translate-x-1.5" />
          </a></li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
@endif
