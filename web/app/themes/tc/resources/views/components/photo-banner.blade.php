{{-- Fotobanner: schermvullende foto met titel (optioneel gekleurde tweede regel), tekst en knop.
     Gebruik: <x-photo-banner image="..." title="Bij ons word je" highlight="gehoord" href="...">Tekst</x-photo-banner>
     align="left|right": kant van de tekst (het verloop loopt mee); accent="roze|geel|groen|oranje": kleur tweede regel.
     Op de voorpagina gevuld vanuit Trivium Settings > Fotobanner (Composers\PhotoBanner).
     Als slide (data-slide) glijdt hij vanaf tablet in beeld (js/slide-sections.js).
     animate="text" (standaard): zodra de tekst half in beeld is, schuiven de woorden eenmalig na elkaar omhoog
     (x-intersect zet data-shown, woord --i wacht --i × 30ms). Screenreaders krijgen de tekst als één zin (sr-only);
     de opgeknipte, geanimeerde woorden zijn aria-hidden.
     animate="title": de titelregels rollen eenmalig van links naar rechts uit (clip-path), de tweede regel iets later;
     de broodtekst staat stil.
     Leesbaarheid: vanaf desktop blijft het verloop donker tot voorbij de tekst.
     Vlak vanaf lg breder (max-w-2xl) zodat de witte titelregel op één regel past; de broodtekst blijft smaller (max-w-xl). --}}
@props([
  'image',
  'title',
  'highlight' => null,
  'href' => null,
  'linkText' => 'Lees meer',
  'target' => null,
  'align' => 'left',
  'accent' => 'roze',
  'animate' => 'text',
])

@php($words = preg_split('/\s+/', trim(strip_tags($slot))))
@php($right = $align === 'right')
@php($accentClass = match ($accent) {
  'geel' => 'text-triv-yellow',
  'groen' => 'text-triv-green',
  'oranje' => 'text-triv-orange',
  default => 'text-triv-pink',
})

<section data-slide class="relative h-svh overflow-hidden">
  <img src="{{ $image }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover">

  <div @class([
    'absolute inset-0 from-black/70 via-black/30 to-transparent lg:from-black/80 lg:via-black/50 lg:via-40%',
    'bg-gradient-to-r' => ! $right,
    'bg-gradient-to-l' => $right,
  ])></div>

  <div @class(['relative z-10 h-full page-container flex items-center', 'justify-end' => $right])>
    <div class="max-w-md lg:max-w-2xl">
      @if($animate === 'title')
        @php($unroll = 'block w-fit [clip-path:inset(0_100%_0_0)] transition-[clip-path] duration-1000 ease-[cubic-bezier(.65,0,.25,1)] group-data-shown:[clip-path:inset(0)] motion-reduce:[clip-path:inset(0)] motion-reduce:transition-none')
        <h2 class="group text-5xl xl:text-6xl font-bold text-white leading-tight mb-6" x-data x-intersect.once.half="$el.dataset.shown = ''">
          <span class="{{ $unroll }}">{{ $title }}</span>
          @if($highlight)
            <span class="{{ $unroll }} delay-400 {{ $accentClass }}">{{ $highlight }}</span>
          @endif
        </h2>
        <p class="text-white font-medium leading-relaxed mb-8 max-w-xl">{{ implode(' ', $words) }}</p>
      @else
        <h2 class="text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">
          {{ $title }}
          @if($highlight)
            <br><span class="{{ $accentClass }}">{{ $highlight }}</span>
          @endif
        </h2>
        <p class="sr-only">{{ implode(' ', $words) }}</p>
        <p aria-hidden="true" class="group text-white font-medium leading-relaxed mb-8 max-w-xl" x-data x-intersect.once.half="$el.dataset.shown = ''">
          @foreach($words as $i => $word)
            <span class="inline-block overflow-clip -my-1 py-1 align-bottom"><span class="inline-block translate-y-2/3 opacity-0 transition-[translate,opacity] duration-700 ease-out delay-[calc(var(--i)*30ms)] group-data-shown:translate-y-0 group-data-shown:opacity-100 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none" style="--i: {{ $i }}">{{ $word }}</span></span>
          @endforeach
        </p>
      @endif
      @if($href)
        <x-button :href="$href" :target="$target ?: null" :dot="false">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
