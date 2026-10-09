{{-- ── SNELLE LINKS — fotoblokken en "Ga direct naar"-links uit Trivium Settings > Snelle links
     (Composers\QuickLinks), in de stijl van de fotobanner: grote titel met roze tweede regel, en kaarten met
     foto, donker verloop van onder, witte titel en roze pijl. Bij hover zoomt de foto iets in.
     Mobiel alles onder elkaar, vanaf lg twee kolommen. ── --}}
@if($links || $ctas)
<section class="bg-white py-16 md:py-24">
  <div class="page-container grid gap-12 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:gap-20">

    {{-- Titel + fotoblokken (ook op mobiel naast elkaar) --}}
    <div>
      {{-- Zonder ingevulde titel toch een (onzichtbare) h2, zodat de h3's eronder niet los hangen --}}
      @if(! $title)
        <h2 class="sr-only">Snelle links</h2>
      @endif
      @if($title)
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-8">
          {{ $title }}
          @if($highlight)
            <br><span class="text-triv-pink">{{ $highlight }}</span>
          @endif
        </h2>
      @endif
      <ul class="grid grid-cols-2 gap-3 mb-0">
        @foreach($ctas as $cta)
          <li class="mb-0"><a href="{{ $cta['url'] }}" class="group relative flex aspect-[3/4] items-end overflow-hidden rounded-xl no-underline">
            <img src="{{ $cta['image'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover transition-transform duration-500 group-hover:scale-105">
            <span class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent" aria-hidden="true"></span>
            <div class="relative z-10 p-4 sm:p-5">
              <h3 class="text-lg sm:text-2xl font-bold text-white leading-tight mb-2">{{ $cta['title'] }}</h3>
              <span class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-white/90">
                {{ $cta['text'] }}
                <span class="text-triv-pink text-lg transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true">→</span>
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
          <li class="mb-0"><a href="{{ $link['url'] }}" class="group flex h-full items-center justify-between gap-4 py-4 border-b border-gray-200 no-underline">
            <span class="flex flex-col">
              <span class="text-lg font-bold text-gray-900 group-hover:text-triv-pink transition-colors">{{ $link['title'] }}</span>
              <span class="text-sm text-gray-600 mt-0.5">{{ $link['text'] }}</span>
            </span>
            <span class="text-triv-pink text-xl transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true">→</span>
          </a></li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
@endif
